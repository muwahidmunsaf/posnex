<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\ExternalSale;
use App\Models\ExternalPurchase;
use App\Models\Purchase;
use App\Models\Inventory;
use App\Models\Expense;
use App\Models\InventorySale;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403, 'Unauthorized');
        }

        $companyId = Auth::user()->company_id;
        $from = $request->input('from') ? \Carbon\Carbon::parse($request->input('from'))->startOfDay() : null;
        $to = $request->input('to') ? \Carbon\Carbon::parse($request->input('to'))->endOfDay() : null;

        // Sales
        $internalSalesQuery = \App\Models\Sale::where('company_id', $companyId);
        $externalSalesQuery = \App\Models\ExternalSale::where('company_id', $companyId);
        if ($from) { $internalSalesQuery->where('created_at', '>=', $from); $externalSalesQuery->where('created_at', '>=', $from); }
        if ($to) { $internalSalesQuery->where('created_at', '<=', $to); $externalSalesQuery->where('created_at', '<=', $to); }
        $totalInternalSales = $internalSalesQuery->sum('total_amount');
        $totalExternalSales = $externalSalesQuery->sum('total_amount');
        // $totalSales = $totalInternalSales + $totalExternalSales; // Remove this line to avoid double-counting
        $totalSales = $totalInternalSales; // Use only internal sales, since finance report already includes both

        // Purchases
        $internalPurchasesQuery = \App\Models\PurchaseItem::whereHas('purchase', function ($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId);
            if ($from) $q->where('created_at', '>=', $from);
            if ($to) $q->where('created_at', '<=', $to);
        });
        $externalPurchasesQuery = \App\Models\ExternalPurchase::where('company_id', $companyId);
        if ($from) $externalPurchasesQuery->where('created_at', '>=', $from);
        if ($to) $externalPurchasesQuery->where('created_at', '<=', $to);
        $totalInternalPurchases = $internalPurchasesQuery->sum('purchase_amount');
        $totalExternalPurchases = $externalPurchasesQuery->sum('purchase_amount');
        $totalPurchases = $totalInternalPurchases + $totalExternalPurchases;

        // Returns
        $returnsQuery = \App\Models\ReturnTransaction::whereHas('sale', function($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId);
            if ($from) $q->where('created_at', '>=', $from);
            if ($to) $q->where('created_at', '<=', $to);
        });
        $totalReturns = $returnsQuery->sum(DB::raw('amount * quantity'));
        $returnItemsCount = $returnsQuery->sum('quantity');
        $netSale = $totalSales - $totalReturns;

        // Payments Received
        $paymentsReceivedQuery = \App\Models\Sale::where('company_id', $companyId);
        if ($from) $paymentsReceivedQuery->where('created_at', '>=', $from);
        if ($to) $paymentsReceivedQuery->where('created_at', '<=', $to);
        $paymentsReceived = $paymentsReceivedQuery->sum('amount_received');

        // Pending Balance
        $pendingBalanceQuery = \App\Models\Sale::where('company_id', $companyId)->whereIn('sale_type', ['wholesale', 'distributor']);
        if ($from) $pendingBalanceQuery->where('created_at', '>=', $from);
        if ($to) $pendingBalanceQuery->where('created_at', '<=', $to);
        $pendingBalance = $pendingBalanceQuery->sum(DB::raw('total_amount - IFNULL(amount_received, 0)'));

        // Accounts Payable (PKR)
        $totalPurchasesPKRQuery = \App\Models\Purchase::where('company_id', $companyId);
        if ($from) $totalPurchasesPKRQuery->where('created_at', '>=', $from);
        if ($to) $totalPurchasesPKRQuery->where('created_at', '<=', $to);
        $totalPurchasesPKR = $totalPurchasesPKRQuery->sum('pkr_amount');
        $totalSupplierPaymentsPKRQuery = \App\Models\SupplierPayment::whereHas('supplier', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        });
        if ($from) $totalSupplierPaymentsPKRQuery->where('payment_date', '>=', $from);
        if ($to) $totalSupplierPaymentsPKRQuery->where('payment_date', '<=', $to);
        $totalSupplierPaymentsPKR = $totalSupplierPaymentsPKRQuery->sum('pkr_amount');
        $accountsPayablePKR = $totalPurchasesPKR - $totalSupplierPaymentsPKR;

        // Expenses (categorized)
        $expensesQuery = \App\Models\Expense::where('company_id', $companyId);
        if ($from) $expensesQuery->where('created_at', '>=', $from);
        if ($to) $expensesQuery->where('created_at', '<=', $to);
        $expenses = $expensesQuery->get();
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
        $totalExpenses = $expenses->sum('amount');

        // Inventory Count (all time, not filtered)
        $inventoryCount = \App\Models\Inventory::where('company_id', $companyId)->count();

        // Counts (all time, not filtered)
        $suppliersCount = \App\Models\Supplier::where('company_id', $companyId)->count();
        $customersCount = \App\Models\Customer::where('company_id', $companyId)->count();
        $shopkeepersCount = \App\Models\Shopkeeper::whereHas('distributor', function($q) use ($companyId) { $q->where('company_id', $companyId); })->count();
        $distributorsCount = \App\Models\Distributor::where('company_id', $companyId)->count();

        // Profits
        $grossProfit = $netSale - $totalPurchases;
        $allExpenses = $generalExpense + $marketingExpense + $utilityExpense + $salaryExpense + $miscExpense;
        $netProfit = $grossProfit - $allExpenses;

        $companyName = Auth::user()->company->name ?? 'Company';

        return view('dashboard', compact(
            'totalSales',
            'paymentsReceived',
            'pendingBalance',
            'totalPurchases',
            'totalExpenses',
            'inventoryCount',
            'accountsPayablePKR',
            'totalInternalSales',
            'totalExternalSales',
            'totalInternalPurchases',
            'totalExternalPurchases',
            'suppliersCount',
            'customersCount',
            'shopkeepersCount',
            'distributorsCount',
            'grossProfit',
            'netProfit',
            'from',
            'to',
            'totalReturns',
            'returnItemsCount',
            'companyName'
        ));
    }

    public function print(Request $request)
    {
        if (Auth::user()->role === 'employee') {
            abort(403, 'Unauthorized');
        }

        $companyId = Auth::user()->company_id;
        $from = $request->input('from') ? \Carbon\Carbon::parse($request->input('from'))->startOfDay() : null;
        $to = $request->input('to') ? \Carbon\Carbon::parse($request->input('to'))->endOfDay() : null;

        // Sales
        $internalSalesQuery = \App\Models\Sale::where('company_id', $companyId);
        $externalSalesQuery = \App\Models\ExternalSale::where('company_id', $companyId);
        if ($from) { $internalSalesQuery->where('created_at', '>=', $from); $externalSalesQuery->where('created_at', '>=', $from); }
        if ($to) { $internalSalesQuery->where('created_at', '<=', $to); $externalSalesQuery->where('created_at', '<=', $to); }
        $totalInternalSales = $internalSalesQuery->sum('total_amount');
        $totalExternalSales = $externalSalesQuery->sum('total_amount');
        // $totalSales = $totalInternalSales + $totalExternalSales; // Remove this line to avoid double-counting
        $totalSales = $totalInternalSales; // Use only internal sales, since finance report already includes both

        // Purchases
        $internalPurchasesQuery = \App\Models\PurchaseItem::whereHas('purchase', function ($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId);
            if ($from) $q->where('created_at', '>=', $from);
            if ($to) $q->where('created_at', '<=', $to);
        });
        $externalPurchasesQuery = \App\Models\ExternalPurchase::where('company_id', $companyId);
        if ($from) $externalPurchasesQuery->where('created_at', '>=', $from);
        if ($to) $externalPurchasesQuery->where('created_at', '<=', $to);
        $totalInternalPurchases = $internalPurchasesQuery->sum('purchase_amount');
        $totalExternalPurchases = $externalPurchasesQuery->sum('purchase_amount');
        $totalPurchases = $totalInternalPurchases + $totalExternalPurchases;

        // Returns
        $returnsQuery = \App\Models\ReturnTransaction::whereHas('sale', function($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId);
            if ($from) $q->where('created_at', '>=', $from);
            if ($to) $q->where('created_at', '<=', $to);
        });
        $totalReturns = $returnsQuery->sum(DB::raw('amount * quantity'));
        $returnItemsCount = $returnsQuery->sum('quantity');
        $netSale = $totalSales - $totalReturns;

        // Payments Received
        $paymentsReceivedQuery = \App\Models\Sale::where('company_id', $companyId);
        if ($from) $paymentsReceivedQuery->where('created_at', '>=', $from);
        if ($to) $paymentsReceivedQuery->where('created_at', '<=', $to);
        $paymentsReceived = $paymentsReceivedQuery->sum('amount_received');

        // Pending Balance
        $pendingBalanceQuery = \App\Models\Sale::where('company_id', $companyId)->whereIn('sale_type', ['wholesale', 'distributor']);
        if ($from) $pendingBalanceQuery->where('created_at', '>=', $from);
        if ($to) $pendingBalanceQuery->where('created_at', '<=', $to);
        $pendingBalance = $pendingBalanceQuery->sum(DB::raw('total_amount - IFNULL(amount_received, 0)'));

        // Accounts Payable (PKR)
        $totalPurchasesPKRQuery = \App\Models\Purchase::where('company_id', $companyId);
        if ($from) $totalPurchasesPKRQuery->where('created_at', '>=', $from);
        if ($to) $totalPurchasesPKRQuery->where('created_at', '<=', $to);
        $totalPurchasesPKR = $totalPurchasesPKRQuery->sum('pkr_amount');
        $totalSupplierPaymentsPKRQuery = \App\Models\SupplierPayment::whereHas('supplier', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        });
        if ($from) $totalSupplierPaymentsPKRQuery->where('payment_date', '>=', $from);
        if ($to) $totalSupplierPaymentsPKRQuery->where('payment_date', '<=', $to);
        $totalSupplierPaymentsPKR = $totalSupplierPaymentsPKRQuery->sum('pkr_amount');
        $accountsPayablePKR = $totalPurchasesPKR - $totalSupplierPaymentsPKR;

        // Expenses (categorized)
        $expensesQuery = \App\Models\Expense::where('company_id', $companyId);
        if ($from) $expensesQuery->where('created_at', '>=', $from);
        if ($to) $expensesQuery->where('created_at', '<=', $to);
        $expenses = $expensesQuery->get();
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
        $totalExpenses = $expenses->sum('amount');

        // Inventory Count (all time, not filtered)
        $inventoryCount = \App\Models\Inventory::where('company_id', $companyId)->count();

        // Counts (all time, not filtered)
        $suppliersCount = \App\Models\Supplier::where('company_id', $companyId)->count();
        $customersCount = \App\Models\Customer::where('company_id', $companyId)->count();
        $shopkeepersCount = \App\Models\Shopkeeper::whereHas('distributor', function($q) use ($companyId) { $q->where('company_id', $companyId); })->count();
        $distributorsCount = \App\Models\Distributor::where('company_id', $companyId)->count();

        // Profits
        $grossProfit = $netSale - $totalPurchases;
        $allExpenses = $generalExpense + $marketingExpense + $utilityExpense + $salaryExpense + $miscExpense;
        $netProfit = $grossProfit - $allExpenses;

        $companyName = Auth::user()->company->name ?? 'Company';

        return view('dashboard.print', compact(
            'totalSales',
            'paymentsReceived',
            'pendingBalance',
            'totalPurchases',
            'totalExpenses',
            'inventoryCount',
            'accountsPayablePKR',
            'totalInternalSales',
            'totalExternalSales',
            'totalInternalPurchases',
            'totalExternalPurchases',
            'suppliersCount',
            'customersCount',
            'shopkeepersCount',
            'distributorsCount',
            'grossProfit',
            'netProfit',
            'from',
            'to',
            'totalReturns',
            'returnItemsCount',
            'companyName'
        ));
    }
}
