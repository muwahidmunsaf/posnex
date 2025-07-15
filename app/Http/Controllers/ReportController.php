<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\ExternalSale;
use App\Models\ExternalPurchase;
use App\Models\Purchase;
use App\Models\Inventory;
use App\Models\Expense;
use App\Models\InventorySale;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Display all reports
    public function index()
    {
        return view('reports.index');
    }

    // Stock Report
    public function stock(Request $request)
    {
        $user = Auth::user();
        $companyId = $user->company_id;

        // Get all inventory items with current stock for this company
        $inventories = Inventory::where('company_id', $companyId)->get();

        return view('report.stock', compact('inventories'));
    }

    // Purchases Report

    public function purchase(Request $request)
{
    $companyId = Auth::user()->company_id;

    $query = Purchase::with('supplier', 'items')
        ->where('company_id', $companyId)
        ->latest();

    if ($request->filled('search')) {
        $query->whereHas('supplier', function ($q) use ($request) {
            $q->where('supplier_name', 'like', '%' . $request->search . '%');
        })->orWhere('total_amount', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('from')) {
        $query->whereDate('purchase_date', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('purchase_date', '<=', $request->to);
    }

    $purchases = $query->paginate(10)->withQueryString();

    return view('report.purchase', compact('purchases'));
}


    // Sales Report
    public function sales()
    {
        return view('reports.sales');
    }

    // Invoice List
    public function invoices(Request $request)
    {
        $query = Sale::with('customer') // eager load customer
            ->where('company_id', Auth::user()->company_id);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_code', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($subQuery) use ($request) {
                        $subQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $sales = $query->latest()->paginate(20);

        return view('report.invoices', [
            'sales' => $sales,
            'search' => $request->search,
            'date' => $request->date,
        ]);
    }

    public function externalSales(Request $request)
    {
        $user = Auth::user();
        $query = ExternalSale::where('company_id', $user->company_id);

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $sales = $query->latest()->paginate(20);
        return view('report.external-sales', compact('sales'));
    }


    public function externalPurchases(Request $request)
    {
        $user = Auth::user();
        $query = ExternalPurchase::where('company_id', $user->company_id);

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $purchases = $query->latest()->paginate(20);
        return view('report.external-purchases', compact('purchases'));
    }
    public function financeReport(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->startOfMonth();
        $to = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();

        // Purchases
        $totalPurchase = PurchaseItem::whereHas('purchase', function ($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId)
                ->whereBetween('created_at', [$from, $to]);
        })->sum(DB::raw('purchase_amount'));

        // Sales
        $totalSale = Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total_amount');

        // External Purchases
        $externalPurchase = ExternalPurchase::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('purchase_amount');

        // External Sales
        $externalSale = ExternalSale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total_amount');

        // Returns
        $totalReturns = \App\Models\ReturnTransaction::whereHas('sale', function($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId)
              ->whereBetween('created_at', [$from, $to]);
        })->sum(DB::raw('amount * quantity'));

        $netSale = $totalSale - $totalReturns;

        // Payments received (all sales in range)
        $paymentsReceived = \App\Models\Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('amount_received');

        // Pending balance (wholesale + distributor sales in range)
        $pendingBalance = \App\Models\Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->whereIn('sale_type', ['wholesale', 'distributor'])
            ->sum(DB::raw('total_amount - IFNULL(amount_received, 0)'));

        // Accounts Payable (PKR)
        $totalPurchasesPKR = \App\Models\Purchase::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('pkr_amount');
        $totalSupplierPaymentsPKR = \App\Models\SupplierPayment::whereHas('supplier', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->whereBetween('payment_date', [$from, $to])->sum('pkr_amount');
        $accountsPayablePKR = $totalPurchasesPKR - $totalSupplierPaymentsPKR;

        // Expense Categories
        $expenses = \App\Models\Expense::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->get();
        $generalExpense = $expenses->filter(function($e) {
            return !preg_match('/salary payment/i', $e->purpose)
                && !preg_match('/marketing/i', $e->purpose)
                && !preg_match('/utility|bill/i', $e->purpose)
                && !preg_match('/misc/i', $e->purpose);
        })->sum('amount');
        $marketingExpense = $expenses->filter(function($e) {
            return preg_match('/marketing/i', $e->purpose);
        })->sum('amount');
        $utilityExpense = $expenses->filter(function($e) {
            return preg_match('/utility|bill/i', $e->purpose);
        })->sum('amount');
        $salaryExpense = $expenses->filter(function($e) {
            return preg_match('/salary payment/i', $e->purpose);
        })->sum('amount');
        $miscExpense = $expenses->filter(function($e) {
            return preg_match('/misc/i', $e->purpose);
        })->sum('amount');
        $totalExpense = $expenses->sum('amount');

        // Cash Inflows (Sales and Payments with payment_method = cash)
        $cashSales = Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_method', 'cash')
            ->sum('amount_received');
        $cashExternalSales = ExternalSale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_method', 'cash')
            ->sum('total_amount');
        // Payments table (if you want to include direct payments, add here)
        // $cashPayments = Payment::where('company_id', $companyId)->where('payment_method', 'cash')->sum('amount_paid');
        $totalCashIn = $cashSales + $cashExternalSales;

        // Cash Outflows (Expenses and Supplier Payments with paymentWay/payment_method = cash)
        $cashExpenses = $expenses->filter(function($e) {
            return $e->paymentWay === 'cash';
        })->sum('amount');
        $cashSupplierPayments = \App\Models\SupplierPayment::whereHas('supplier', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->whereBetween('payment_date', [$from, $to])->where('payment_method', 'cash')->sum('pkr_amount');
        $totalCashOut = $cashExpenses + $cashSupplierPayments;

        $cashInHand = $totalCashIn - $totalCashOut;
        $netCashFlow = $totalCashIn - $totalCashOut;

        // Gross Profit and Net Profit
        $grossProfit = $netSale - $totalPurchase;
        $allExpenses = $generalExpense + $marketingExpense + $utilityExpense + $salaryExpense + $miscExpense;
        $netProfit = $grossProfit - $allExpenses;

        return view('report.finance', compact(
            'from',
            'to',
            'totalPurchase',
            'externalPurchase',
            'totalSale',
            'externalSale',
            'totalExpense',
            'totalReturns',
            'netSale',
            'paymentsReceived',
            'pendingBalance',
            'accountsPayablePKR',
            'generalExpense',
            'marketingExpense',
            'utilityExpense',
            'salaryExpense',
            'miscExpense',
            'cashInHand',
            'grossProfit',
            'netProfit',
            'netCashFlow'
        ));
    }

    public function dailySales(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $date = $request->input('date', now()->toDateString());

        $sales = \App\Models\Sale::with('inventorySales.item')
            ->where('company_id', $companyId)
            ->whereDate('created_at', $date)
            ->get();

        $summary = [];
        $totalSales = 0;
        $totalProfit = 0;

        foreach ($sales as $sale) {
            foreach ($sale->inventorySales as $detail) {
                $item = $detail->item;
                $qty = $detail->quantity;
                $amount = $detail->amount;
                $total = $amount * $qty;
                $sourcing = $item->sourcing_price ?? 0;
                $profit = ($amount - $sourcing) * $qty;

                if (!isset($summary[$item->id])) {
                    $summary[$item->id] = [
                        'name' => $item->item_name,
                        'qty' => 0,
                        'total' => 0,
                        'profit' => 0,
                    ];
                }
                $summary[$item->id]['qty'] += $qty;
                $summary[$item->id]['total'] += $total;
                $summary[$item->id]['profit'] += $profit;
                $totalSales += $total;
                $totalProfit += $profit;
            }
        }

        return view('reports.daily-sales', compact('summary', 'totalSales', 'totalProfit', 'date'));
    }
}
