<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Shopkeeper;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $distributors = Distributor::all();
        $totalDistributors = $distributors->count();
        $totalPaidCommission = 0;
        $totalPendingCommission = 0;
        $totalRemainingAmount = 0;
        $totalOpeningOutstanding = \App\Models\ShopkeeperTransaction::where('type', 'product_sold')->where('description', 'Opening Outstanding')->sum('total_amount');
        foreach ($distributors as $distributor) {
            // Use withTrashed to include soft-deleted shopkeepers
            $shopkeepers = $distributor->shopkeepers()->withTrashed()->get();
            $sales = \App\Models\Sale::whereIn('shopkeeper_id', $shopkeepers->pluck('id'))->get();
            $totalSales = $sales->sum('total_amount');
            $commissionRate = $distributor->commission_rate ?? 0;
            $computedCommission = $totalSales * $commissionRate / 100;
            $paidCommission = $distributor->payments()->where('type', 'commission')->sum('amount');
            $pendingCommission = max($computedCommission - $paidCommission, 0);
            $openingOutstanding = \App\Models\ShopkeeperTransaction::whereIn('shopkeeper_id', $shopkeepers->pluck('id'))
                ->where('type', 'product_sold')
                ->where('description', 'Opening Outstanding')
                ->sum('total_amount');
            $paymentsReceived = \App\Models\ShopkeeperTransaction::whereIn('shopkeeper_id', $shopkeepers->pluck('id'))
                ->where('type', 'payment_made')
                ->sum('total_amount');
            $remainingAmount = $sales->sum(function($sale) { return ($sale->total_amount - ($sale->amount_received ?? 0)); });
            $remainingAmount = $remainingAmount + $openingOutstanding - $paymentsReceived;
            $totalPaidCommission += $paidCommission;
            $totalPendingCommission += $pendingCommission;
            $totalRemainingAmount += $remainingAmount;
        }
        $totalRemainingAmount += $totalOpeningOutstanding;
        return view('distributors.index', compact('distributors', 'totalDistributors', 'totalPaidCommission', 'totalPendingCommission', 'totalRemainingAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('distributors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'commission_rate' => 'nullable|numeric',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        $distributor = Distributor::create($data);
        // Log the activity
        $this->logCreate($distributor, 'Distributor', $distributor->name);
        return redirect()->route('distributors.index')->with('success', 'Distributor added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        // Show distributor details and shopkeepers
        // Use withTrashed to include soft-deleted shopkeepers
        $shopkeepers = $distributor->shopkeepers()->withTrashed()->get();
        // Log the activity
        $this->logActivity('Viewed Distributor', $distributor->name);
        return view('distributors.show', compact('distributor', 'shopkeepers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        return view('distributors.edit', compact('distributor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'commission_rate' => 'nullable|numeric',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        $distributor->update($data);
        // Log the activity
        $this->logUpdate($distributor, 'Distributor', $distributor->name);
        return redirect()->route('distributors.index')->with('success', 'Distributor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        // Log the activity before deletion
        $this->logDelete($distributor, 'Distributor', $distributor->name);
        $distributor->delete();
        return redirect()->route('distributors.index')->with('success', 'Distributor deleted successfully.');
    }

    public function history(Distributor $distributor)
    {
        // Use withTrashed to include soft-deleted shopkeepers
        $shopkeepers = $distributor->shopkeepers()->withTrashed()->get();
        // Get all sales for all shopkeepers under this distributor
        $sales = \App\Models\Sale::whereIn('shopkeeper_id', $shopkeepers->pluck('id'))->with(['shopkeeper', 'customer'])->get();
        $totalSales = $sales->sum('total_amount');
        $totalOutstanding = $sales->sum(function($sale) {
            return ($sale->total_amount - ($sale->amount_received ?? 0));
        });
        // Log the activity
        $this->logActivity('Viewed Distributor History', $distributor->name);
        return view('distributors.history', compact('distributor', 'shopkeepers', 'sales', 'totalSales', 'totalOutstanding'));
    }

    public function printHistory(Distributor $distributor)
    {
        // Use withTrashed to include soft-deleted shopkeepers
        $shopkeepers = $distributor->shopkeepers()->withTrashed()->get();
        $sales = \App\Models\Sale::whereIn('shopkeeper_id', $shopkeepers->pluck('id'))->with(['shopkeeper', 'customer'])->get();
        $totalSales = $sales->sum('total_amount');
        $totalOutstanding = $sales->sum(function($sale) {
            return ($sale->total_amount - ($sale->amount_received ?? 0));
        });
        $commissionPayments = $distributor->payments()->where('type', 'commission')->orderByDesc('payment_date')->get();
        $paidCommission = $commissionPayments->sum('amount');
        $computedCommission = $totalSales * ($distributor->commission_rate ?? 0) / 100;
        $remainingCommission = max($computedCommission - $paidCommission, 0);
        // Shopkeeper summary table
        $shopkeeperSummaries = $shopkeepers->map(function($shopkeeper) {
            $totalSale = \App\Models\Sale::where('shopkeeper_id', $shopkeeper->id)->sum('total_amount');
            $received = \App\Models\Sale::where('shopkeeper_id', $shopkeeper->id)->sum('amount_received');
            $balance = $totalSale - $received;
            return [
                'name' => $shopkeeper->name,
                'total_sale' => $totalSale,
                'received' => $received,
                'balance' => $balance,
            ];
        });
        // Log the activity
        $this->logExport('Distributor History', 'PDF');
        return view('distributors.print_history', compact(
            'distributor',
            'shopkeepers',
            'sales',
            'totalSales',
            'totalOutstanding',
            'commissionPayments',
            'paidCommission',
            'computedCommission',
            'remainingCommission',
            'shopkeeperSummaries'
        ));
    }

    public function printAll(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $distributors = \App\Models\Distributor::with('shopkeepers')->get();
        $summary = $distributors->map(function($distributor, $i) use ($startDate, $endDate) {
            // Use withTrashed to include soft-deleted shopkeepers
            $shopkeepers = $distributor->shopkeepers()->withTrashed()->get();
            $salesQuery = \App\Models\Sale::whereIn('shopkeeper_id', $shopkeepers->pluck('id'));
            if ($startDate) $salesQuery->whereDate('created_at', '>=', $startDate);
            if ($endDate) $salesQuery->whereDate('created_at', '<=', $endDate);
            $totalSales = $salesQuery->sum('total_amount');
            $commissionRate = $distributor->commission_rate ?? 0;
            $computedCommission = $totalSales * $commissionRate / 100;
            $paymentsQuery = $distributor->payments()->where('type', 'commission');
            if ($startDate) $paymentsQuery->whereDate('payment_date', '>=', $startDate);
            if ($endDate) $paymentsQuery->whereDate('payment_date', '<=', $endDate);
            $paidCommission = $paymentsQuery->sum('amount');
            $remainingCommission = max($computedCommission - $paidCommission, 0);
            $totalShopkeepers = $shopkeepers->count();
            $balance = $totalSales - $paidCommission;
            return [
                'sr' => $i+1,
                'name' => $distributor->name,
                'commission_rate' => $commissionRate,
                'total_commission' => $computedCommission,
                'paid' => $paidCommission,
                'remaining' => $remainingCommission,
                'total_shopkeepers' => $totalShopkeepers,
                'total_sales' => $totalSales,
                'balance' => $balance,
            ];
        });
        // Log the activity
        $this->logExport('All Distributors Report', 'PDF');
        return view('distributors.print_all', compact('summary', 'startDate', 'endDate'));
    }

    /**
     * Display a listing of soft-deleted distributors.
     */
    public function deletedDistributors()
    {
        $deletedDistributors = Distributor::onlyTrashed()->get();
        return view('distributors.deleted', compact('deletedDistributors'));
    }

    /**
     * Restore a soft-deleted distributor.
     */
    public function restore($id)
    {
        $distributor = Distributor::onlyTrashed()->findOrFail($id);
        $distributor->restore();
        return redirect()->route('recycle.bin')->with('success', 'Distributor restored successfully.');
    }
}
