<?php

namespace App\Http\Controllers;

use App\Models\Shopkeeper;
use App\Models\Distributor;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopkeeperController extends Controller
{
    use LogsActivity;

    // Removed constructor middleware. Use route middleware in routes/web.php instead.

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $distributor_id = $request->get('distributor_id');
        $query = Shopkeeper::query();
        if ($distributor_id) {
            $query->where('distributor_id', $distributor_id);
        }
        $shopkeepers = $query->get();
        $totalShopkeepers = $shopkeepers->count();
        $totalSales = 0;
        $totalReceived = 0;
        $totalBalance = 0;
        foreach ($shopkeepers as $shopkeeper) {
            $sales = \App\Models\Sale::where('shopkeeper_id', $shopkeeper->id)->get();
            $totalSale = $sales->sum('total_amount');
            $receivedFromSales = $sales->sum('amount_received');
            // Add payments from ShopkeeperTransaction of type 'payment_made'
            $receivedFromPayments = $shopkeeper->transactions()->where('type', 'payment_made')->sum('total_amount');
            $received = $receivedFromSales + $receivedFromPayments;
            $balance = $totalSale - $received;
            $totalSales += $totalSale;
            $totalReceived += $received;
            $totalBalance += $balance;
        }
        return view('shopkeepers.index', compact('shopkeepers', 'distributor_id', 'totalShopkeepers', 'totalSales', 'totalReceived', 'totalBalance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $distributor_id = $request->get('distributor_id');
        $distributors = Distributor::all();
        return view('shopkeepers.create', compact('distributors', 'distributor_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $data = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'remaining_amount' => 'nullable|numeric|min:0',
        ]);
        // Ensure distributor has the same company as the user
        $distributor = \App\Models\Distributor::find($data['distributor_id']);
        if ($distributor && !$distributor->company_id) {
            $distributor->company_id = auth()->user()->company_id;
            $distributor->save();
        }
        $remaining = $request->input('remaining_amount', 0);
        $shopkeeper = Shopkeeper::create($data);
        // If remaining_amount is set, create an initial outstanding transaction
        if ($remaining > 0) {
            \App\Models\ShopkeeperTransaction::create([
                'shopkeeper_id' => $shopkeeper->id,
                'distributor_id' => $shopkeeper->distributor_id,
                'type' => 'product_sold',
                'quantity' => 1,
                'unit_price' => $remaining,
                'total_amount' => $remaining,
                'commission_amount' => 0,
                'transaction_date' => now(),
                'description' => 'Opening Outstanding',
                'status' => 'completed',
            ]);
        }
        // Log the activity
        $this->logCreate($shopkeeper, 'Shopkeeper', $shopkeeper->name);
        return redirect()->route('shopkeepers.index', ['distributor_id' => $data['distributor_id']])->with('success', 'Shopkeeper added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shopkeeper $shopkeeper)
    {
        // Get all sales for this shopkeeper
        $sales = \App\Models\Sale::where('shopkeeper_id', $shopkeeper->id)->with(['distributor', 'customer'])->get();
        $totalSales = $sales->sum('total_amount');
        $totalOutstanding = $sales->sum(function($sale) {
            return ($sale->total_amount - ($sale->amount_received ?? 0));
        });
        // Log the activity
        $this->logActivity('Viewed Shopkeeper', $shopkeeper->name);
        return view('shopkeepers.show', compact('shopkeeper', 'sales', 'totalSales', 'totalOutstanding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shopkeeper $shopkeeper)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $distributors = Distributor::all();
        return view('shopkeepers.edit', compact('shopkeeper', 'distributors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shopkeeper $shopkeeper)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $data = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'remaining_amount' => 'nullable|numeric|min:0',
        ]);
        // Ensure distributor has the same company as the user
        $distributor = \App\Models\Distributor::find($data['distributor_id']);
        if ($distributor && !$distributor->company_id) {
            $distributor->company_id = Auth::user()->company_id;
            $distributor->save();
        }
        // Always set remaining_amount to the provided value
        $shopkeeper->remaining_amount = $data['remaining_amount'] ?? 0;
        $shopkeeper->update($data);
        // Update or create opening outstanding transaction
        $remaining = $shopkeeper->remaining_amount;
        $opening = $shopkeeper->transactions()->where('type', 'product_sold')->where('description', 'Opening Outstanding')->latest()->first();
        if ($remaining > 0) {
            if ($opening) {
                $opening->update(['total_amount' => $remaining, 'unit_price' => $remaining]);
            } else {
                \App\Models\ShopkeeperTransaction::create([
                    'shopkeeper_id' => $shopkeeper->id,
                    'distributor_id' => $shopkeeper->distributor_id,
                    'type' => 'product_sold',
                    'quantity' => 1,
                    'unit_price' => $remaining,
                    'total_amount' => $remaining,
                    'commission_amount' => 0,
                    'transaction_date' => now(),
                    'description' => 'Opening Outstanding',
                    'status' => 'completed',
                ]);
            }
        } else if ($opening) {
            $opening->delete();
        }
        // Log the activity
        $this->logUpdate($shopkeeper, 'Shopkeeper', $shopkeeper->name);
        return redirect()->route('shopkeepers.index', ['distributor_id' => $data['distributor_id']])->with('success', 'Shopkeeper updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shopkeeper $shopkeeper)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $distributor_id = $shopkeeper->distributor_id;
        // Log the activity before deletion
        $this->logDelete($shopkeeper, 'Shopkeeper', $shopkeeper->name);
        $shopkeeper->delete();
        return redirect()->route('shopkeepers.index', ['distributor_id' => $distributor_id])->with('success', 'Shopkeeper deleted successfully.');
    }

    /**
     * Display a listing of soft-deleted shopkeepers.
     */
    public function deletedShopkeepers()
    {
        $deletedShopkeepers = Shopkeeper::onlyTrashed()->get();
        return view('shopkeepers.deleted', compact('deletedShopkeepers'));
    }

    /**
     * Restore a soft-deleted shopkeeper.
     */
    public function restore($id)
    {
        $shopkeeper = Shopkeeper::onlyTrashed()->findOrFail($id);
        $shopkeeper->restore();
        return redirect()->route('recycle.bin')->with('success', 'Shopkeeper restored successfully.');
    }

    /**
     * Print the full history for the specified shopkeeper.
     */
    public function printHistory($id)
    {
        $shopkeeper = Shopkeeper::with('distributor.company')->findOrFail($id);
        $startDate = request('from');
        $endDate = request('to');

        $salesQuery = \App\Models\Sale::where('shopkeeper_id', $shopkeeper->id)->with(['returns', 'inventorySales.item']);
        $paymentsQuery = $shopkeeper->transactions()->where('type', 'payment_made');

        if ($startDate) {
            $salesQuery->whereDate('created_at', '>=', $startDate);
            $paymentsQuery->whereDate('transaction_date', '>=', $startDate);
        }
        if ($endDate) {
            $salesQuery->whereDate('created_at', '<=', $endDate);
            $paymentsQuery->whereDate('transaction_date', '<=', $endDate);
        }

        $sales = $salesQuery->get();
        $payments = $paymentsQuery->get();

        $totalSales = $sales->sum('total_amount');
        $totalReturns = 0;
        foreach ($sales as $sale) {
            $sale->total_returned = $sale->returns->sum(function($ret) {
                return $ret->amount * $ret->quantity;
            });
            $totalReturns += $sale->total_returned;
            $sale->outstanding = $sale->total_amount - $sale->total_returned;
        }
        $totalPaid = $payments->sum('total_amount');
        $outstanding = ($totalSales - $totalReturns) - $totalPaid;

        // Log the activity
        $this->logExport('Shopkeeper History', 'PDF');

        return view('shopkeepers.print_history', compact('shopkeeper', 'sales', 'payments', 'totalSales', 'totalReturns', 'totalPaid', 'outstanding', 'startDate', 'endDate'));
    }

    public function printAll(Request $request)
    {
        $startDate = $request->query('from');
        $endDate = $request->query('to');
        $shopkeepers = \App\Models\Shopkeeper::with('distributor')->get();
        $summary = $shopkeepers->map(function($shopkeeper, $i) use ($startDate, $endDate) {
            $salesQuery = \App\Models\Sale::where('shopkeeper_id', $shopkeeper->id);
            if ($startDate) $salesQuery->whereDate('created_at', '>=', $startDate);
            if ($endDate) $salesQuery->whereDate('created_at', '<=', $endDate);
            $totalSales = $salesQuery->sum('total_amount');
            $paymentsQuery = $shopkeeper->transactions()->where('type', 'payment_made');
            if ($startDate) $paymentsQuery->whereDate('transaction_date', '>=', $startDate);
            if ($endDate) $paymentsQuery->whereDate('transaction_date', '<=', $endDate);
            $totalPaid = $paymentsQuery->sum('total_amount');
            $balance = $totalSales - $totalPaid;
            return [
                'sr' => $i+1,
                'name' => $shopkeeper->name,
                'distributor' => $shopkeeper->distributor->name ?? '-',
                'total_sales' => $totalSales,
                'paid' => $totalPaid,
                'balance' => $balance,
            ];
        });
        // Log the activity
        $this->logExport('All Shopkeepers Report', 'PDF');
        return view('shopkeepers.print_all', compact('summary', 'startDate', 'endDate'));
    }
}
