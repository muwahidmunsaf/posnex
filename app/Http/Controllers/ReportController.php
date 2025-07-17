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
        // Add sold_unit property to each inventory item
        foreach ($inventories as $item) {
            $item->sold_unit = \App\Models\InventorySale::where('item_id', $item->id)->sum('quantity');
        }

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

        // Purchases (in PKR)
        $totalPurchase = \App\Models\Purchase::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('pkr_amount');

        // Sales
        $totalSale = Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total_amount');

        // Total Tax
        $totalTax = Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('tax_amount');

        // Total Discounts
        $totalDiscounts = Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->sum('discount');

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

        // Net Sales including tax (default)
        $netSaleIncludingTax = $totalSale - $totalReturns - $totalDiscounts;
        // Net Sales excluding tax
        $netSaleExcludingTax = $netSaleIncludingTax - $totalTax;

        // Payments received (sales + direct payments + shopkeeper payments)
        $paymentsReceivedViaSales = \App\Models\Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->get()
            ->sum(function($sale) {
                if ($sale->sale_type === 'retail') {
                    return ($sale->amount_received ?? 0) - ($sale->change_return ?? 0);
                } else {
                    return $sale->amount_received ?? 0;
                }
            });
        $paymentsReceivedViaPayments = \App\Models\Payment::whereHas('customer', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->whereBetween('date', [$from, $to])->sum('amount_paid');
        // Add shopkeeper payments
        $paymentsReceivedViaShopkeepers = \App\Models\ShopkeeperTransaction::where('type', 'payment_made')
            ->whereHas('shopkeeper.distributor', function($q) use ($companyId) { $q->where('company_id', $companyId); })
            ->whereBetween('transaction_date', [$from, $to])
            ->sum('total_amount');
        $paymentsReceived = $paymentsReceivedViaSales + $paymentsReceivedViaPayments + $paymentsReceivedViaShopkeepers;

        // Total received via direct payments (for this company)
        $totalReceivedViaPayments = \App\Models\Payment::whereHas('customer', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->whereBetween('date', [$from, $to])->sum('amount_paid');
        // Total received via sales (wholesale/distributor)
        $totalReceivedViaSales = \App\Models\Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->whereIn('sale_type', ['wholesale', 'distributor'])
            ->sum('amount_received');
        // Pending balance (wholesale/distributor only)
        $pendingBalanceQuery = \App\Models\Sale::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->whereIn('sale_type', ['wholesale', 'distributor']);
        $pendingBalance = $pendingBalanceQuery->sum(DB::raw('total_amount - IFNULL(amount_received, 0)'));

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
            ->get()
            ->sum(function($sale) {
                if ($sale->sale_type === 'retail') {
                    return ($sale->amount_received ?? 0) - ($sale->change_return ?? 0);
                } else {
                    return $sale->amount_received ?? 0;
                }
            });
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
        $grossProfit = $netSaleIncludingTax - $totalPurchase;
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
            'totalTax',
            'totalDiscounts',
            'netSaleIncludingTax',
            'netSaleExcludingTax',
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

    /**
     * Show the recycle bin for deleted suppliers, customers, distributors, and shopkeepers.
     */
    public function recycleBin()
    {
        $deletedSuppliers = \App\Models\Supplier::onlyTrashed()->get();
        $deletedCustomers = \App\Models\Customer::onlyTrashed()->get();
        $deletedDistributors = \App\Models\Distributor::onlyTrashed()->get();
        $deletedShopkeepers = \App\Models\Shopkeeper::onlyTrashed()->get();
        return view('recycle_bin', compact('deletedSuppliers', 'deletedCustomers', 'deletedDistributors', 'deletedShopkeepers'));
    }
}
