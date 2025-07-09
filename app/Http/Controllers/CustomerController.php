<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403, 'Unauthorized');
        }
        $companyId = Auth::user()->company_id;
        $query = Customer::where('company_id', $companyId)
            ->where('type', 'wholesale'); // Only wholesale customers
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        $customers = $query->with('payments')->paginate(10);
        $city = $request->city;
        // Calculate outstanding for each customer
        foreach ($customers as $customer) {
            $customer->outstanding = $customer->payments->sum(function($p) {
                return $p->amount_due - $p->amount_paid;
            });
        }
        return view('customers.index', compact('customers', 'city'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
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

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        // Ensure customer belongs to auth user's company
        if ($customer->company_id != Auth::user()->company_id) {
            abort(403);
        }

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
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

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->company_id != Auth::user()->company_id) {
            abort(403);
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function history($id)
    {
        $customer = Customer::findOrFail($id);
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
}
