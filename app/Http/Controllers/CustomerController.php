<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403, 'Unauthorized');
        }
        $companyId = Auth::user()->company_id;
        $city = $request->city;
        $from = $request->from;
        $to = $request->to;
        $query = Customer::where('company_id', $companyId)
            ->where('type', 'wholesale'); // Only wholesale customers
        if ($city) {
            $query->where('city', 'like', '%' . $city . '%');
        }
        // Only eager load sales/payments within date range
        $customers = $query->with([
            'sales' => function ($q) use ($from, $to) {
                if ($from) $q->where('created_at', '>=', $from);
                if ($to) $q->where('created_at', '<=', $to);
            },
            'payments' => function ($q) use ($from, $to) {
                if ($from) $q->where('created_at', '>=', $from);
                if ($to) $q->where('created_at', '<=', $to);
            }
        ])->paginate(10);
        $totalCustomers = $customers->total();
        $totalReceived = 0;
        $totalBalance = 0;
        $totalSales = 0;
        foreach ($customers as $customer) {
            $received = $customer->payments->sum('amount_paid') + $customer->sales->sum('amount_received');
            $sales = $customer->sales->sum('total_amount');
            $returns = 0;
            foreach ($customer->sales as $sale) {
                $returns += $sale->returns->sum(function($ret) { return $ret->amount * $ret->quantity; });
            }
            $balance = ($sales - $returns) - $received;
            $totalReceived += $received;
            $totalBalance += $balance;
            $totalSales += $sales;
        }
        return view('customers.index', compact('customers', 'city', 'from', 'to', 'totalCustomers', 'totalReceived', 'totalBalance', 'totalSales'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        $companyId = Auth::user()->company_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wholesale', // Only allow wholesale
            'cel_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'cnic' => ['nullable', 'regex:/^\\d{5}-\\d{7}-\\d{1}$/'],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
        ]);

        $validated['company_id'] = $companyId;

        $customer = Customer::create($validated);

        // Log the activity
        $this->logCreate($customer, 'Customer', $customer->name);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        // Ensure customer belongs to auth user's company
        if ($customer->company_id != Auth::user()->company_id) {
            abort(403);
        }

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        if ($customer->company_id != Auth::user()->company_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wholesale', // Only allow wholesale
            'cel_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'cnic' => ['nullable', 'regex:/^\d{5}-\d{7}-\d{1}$/'],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
        ]);

        $customer->update($validated);

        // Log the activity
        $this->logUpdate($customer, 'Customer', $customer->name);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        if ($customer->company_id != Auth::user()->company_id) {
            abort(403);
        }

        // Log the activity before deletion
        $this->logDelete($customer, 'Customer', $customer->name);

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function history($id)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        $customer = Customer::findOrFail($id);
        
        // Log the activity
        $this->logActivity('Viewed Customer History', "Customer: {$customer->name}");
        
        $sales = $customer->sales()->with('returns', 'inventorySales.item')->get();
        $payments = $customer->payments()->orderBy('created_at')->get();

        // Calculate total sales, total returns, total payments
        $totalSales = $sales->sum('total_amount');
        $totalReturns = 0;
        foreach ($sales as $sale) {
            $sale->total_returned = $sale->returns->sum(function($ret) {
                return $ret->amount * $ret->quantity;
            });
            $totalReturns += $sale->total_returned;
            $sale->outstanding = $sale->total_amount - $sale->total_returned;
        }
        $totalPaid = $payments->sum('amount_paid') + $sales->sum('amount_received');
        $outstanding = ($totalSales - $totalReturns) - $totalPaid;

        // Build running balance after each payment/return
        $events = [];
        foreach ($sales as $sale) {
            $events[] = [
                'type' => 'sale',
                'date' => $sale->created_at,
                'desc' => 'Sale: ' . $sale->sale_code,
                'amount' => $sale->total_amount,
                'returns' => $sale->total_returned,
            ];
            foreach ($sale->returns as $ret) {
                $events[] = [
                    'type' => 'return',
                    'date' => $ret->created_at,
                    'desc' => 'Return: ' . ($ret->item->item_name ?? '-') . ' x' . $ret->quantity,
                    'amount' => -($ret->amount * $ret->quantity),
                    'returns' => $ret->amount * $ret->quantity,
                ];
            }
        }
        foreach ($payments as $pay) {
            $events[] = [
                'type' => 'payment',
                'date' => $pay->created_at,
                'desc' => 'Payment',
                'amount' => -$pay->amount_paid,
                'returns' => 0,
            ];
        }
        // Sort all events by date
        usort($events, function($a, $b) {
            return $a['date'] <=> $b['date'];
        });
        // Calculate running balance
        $runningBalance = 0;
        foreach ($events as &$event) {
            $runningBalance += $event['amount'];
            $event['balance'] = $runningBalance;
        }

        return view('customers.history', compact('customer', 'sales', 'payments', 'outstanding', 'events'));
    }

    public function printHistory($id, Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        $customer = Customer::with('company')->findOrFail($id);
        
        // Log the activity
        $this->logExport('Customer History', 'PDF');
        
        $from = $request->query('from');
        $to = $request->query('to');
        $sales = $customer->sales()->with('returns', 'inventorySales.item');
        $payments = $customer->payments();
        if ($from) $sales->whereDate('created_at', '>=', $from);
        if ($to) $sales->whereDate('created_at', '<=', $to);
        if ($from) $payments->whereDate('created_at', '>=', $from);
        if ($to) $payments->whereDate('created_at', '<=', $to);
        $sales = $sales->get();
        $payments = $payments->get();
        $totalSales = $sales->sum('total_amount');
        $totalReturns = 0;
        foreach ($sales as $sale) {
            $sale->total_returned = $sale->returns->sum(function($ret) {
                return $ret->amount * $ret->quantity;
            });
            $totalReturns += $sale->total_returned;
            $sale->outstanding = $sale->total_amount - $sale->total_returned;
        }
        $totalPaid = $payments->sum('amount_paid') + $sales->sum('amount_received');
        $outstanding = ($totalSales - $totalReturns) - $totalPaid;
        $fromParam = $from;
        $toParam = $to;
        return view('customers.print_history', compact('customer', 'sales', 'payments', 'totalSales', 'totalReturns', 'totalPaid', 'outstanding', 'fromParam', 'toParam'));
    }

    public function printAll(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403);
        }
        
        // Log the activity
        $this->logExport('All Customers Report', 'PDF');
        
        $companyId = Auth::user()->company_id;
        $from = $request->query('from');
        $to = $request->query('to');
        $customers = Customer::where('company_id', $companyId)
            ->with(['sales', 'payments'])
            ->get();
        $company = Auth::user()->company;
        $fromParam = $from;
        $toParam = $to;
        // Optionally, filter each customer's sales/payments by date range in the view
        return view('customers.print_all', compact('customers', 'company', 'fromParam', 'toParam'));
    }
}
