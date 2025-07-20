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

        // Purchases (use PKR-converted value)
        $totalPurchasesPKRQuery = \App\Models\Purchase::where('company_id', $companyId);
        if ($from) $totalPurchasesPKRQuery->where('created_at', '>=', $from);
        if ($to) $totalPurchasesPKRQuery->where('created_at', '<=', $to);
        $totalPurchasesPKR = $totalPurchasesPKRQuery->sum('pkr_amount');
        // External Purchases
        $totalExternalPurchases = \App\Models\ExternalPurchase::where('company_id', $companyId);
        if ($from) $totalExternalPurchases->where('created_at', '>=', $from);
        if ($to) $totalExternalPurchases->where('created_at', '<=', $to);
        $totalExternalPurchases = $totalExternalPurchases->sum('purchase_amount');
        // Total Purchases (internal PKR + external)
        $totalPurchases = $totalPurchasesPKR + $totalExternalPurchases;

        // Returns
        $returnsQuery = \App\Models\ReturnTransaction::whereHas('sale', function($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId);
            if ($from) $q->where('created_at', '>=', $from);
            if ($to) $q->where('created_at', '<=', $to);
        });
        $totalReturns = $returnsQuery->sum(DB::raw('amount * quantity'));
        $returnItemsCount = $returnsQuery->sum('quantity');
        $netSale = $totalSales - $totalReturns;

        // Payments Received (sales + direct payments + shopkeeper payments)
        $paymentsReceivedViaSales = \App\Models\Sale::where('company_id', $companyId);
        if ($from) $paymentsReceivedViaSales->where('created_at', '>=', $from);
        if ($to) $paymentsReceivedViaSales->where('created_at', '<=', $to);
        $paymentsReceivedViaSales = $paymentsReceivedViaSales->get()->sum(function($sale) {
            if ($sale->sale_type === 'retail') {
                return ($sale->amount_received ?? 0) - ($sale->change_return ?? 0);
            } else {
                return $sale->amount_received ?? 0;
            }
        });
        $paymentsReceivedViaPayments = \App\Models\Payment::whereHas('customer', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        });
        if ($from) $paymentsReceivedViaPayments->where('date', '>=', $from);
        if ($to) $paymentsReceivedViaPayments->where('date', '<=', $to);
        $paymentsReceivedViaPayments = $paymentsReceivedViaPayments->sum('amount_paid');
        // Include soft-deleted shopkeepers in payments received calculation
        $shopkeeperIds = \App\Models\Shopkeeper::withTrashed()->pluck('id');
        $paymentsReceivedViaShopkeepers = \App\Models\ShopkeeperTransaction::where('type', 'payment_made')
            ->whereIn('shopkeeper_id', $shopkeeperIds);
        if ($from) $paymentsReceivedViaShopkeepers->where('transaction_date', '>=', $from);
        if ($to) $paymentsReceivedViaShopkeepers->where('transaction_date', '<=', $to);
        $paymentsReceivedViaShopkeepers = $paymentsReceivedViaShopkeepers->sum('total_amount');
        $paymentsReceived = $paymentsReceivedViaSales + $paymentsReceivedViaPayments + $paymentsReceivedViaShopkeepers;

        // Total received via direct payments (for this company)
        $totalReceivedViaPayments = \App\Models\Payment::whereHas('customer', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        });
        if ($from) $totalReceivedViaPayments->where('date', '>=', $from);
        if ($to) $totalReceivedViaPayments->where('date', '<=', $to);
        $totalReceivedViaPayments = $totalReceivedViaPayments->sum('amount_paid');
        // Total received via sales (wholesale/distributor)
        $totalReceivedViaSales = \App\Models\Sale::where('company_id', $companyId)
            ->whereIn('sale_type', ['wholesale', 'distributor']);
        if ($from) $totalReceivedViaSales->where('created_at', '>=', $from);
        if ($to) $totalReceivedViaSales->where('created_at', '<=', $to);
        $totalReceivedViaSales = $totalReceivedViaSales->sum('amount_received');
        // Include soft-deleted shopkeepers in pending balance calculation
        $shopkeeperIds = \App\Models\Shopkeeper::withTrashed()->pluck('id');
        $pendingBalanceQuery = \App\Models\Sale::where('company_id', $companyId)
            ->whereIn('sale_type', ['wholesale', 'distributor'])
            ->whereIn('shopkeeper_id', $shopkeeperIds);
        if ($from) $pendingBalanceQuery->where('created_at', '>=', $from);
        if ($to) $pendingBalanceQuery->where('created_at', '<=', $to);
        $pendingBalanceSales = $pendingBalanceQuery->sum(DB::raw('total_amount - IFNULL(amount_received, 0)'));
        // Subtract shopkeeper payments
        $shopkeeperPayments = \App\Models\ShopkeeperTransaction::where('type', 'payment_made')
            ->whereIn('shopkeeper_id', $shopkeeperIds);
        if ($from) $shopkeeperPayments->where('transaction_date', '>=', $from);
        if ($to) $shopkeeperPayments->where('transaction_date', '<=', $to);
        $shopkeeperPayments = $shopkeeperPayments->sum('total_amount');
        // Add pending and received for wholesale customers
        $wholesaleCustomerSales = \App\Models\Sale::where('company_id', $companyId)
            ->where('sale_type', 'wholesale')
            ->whereNotNull('customer_id');
        if ($from) $wholesaleCustomerSales->where('created_at', '>=', $from);
        if ($to) $wholesaleCustomerSales->where('created_at', '<=', $to);
        $pendingWholesaleCustomer = $wholesaleCustomerSales->sum(DB::raw('total_amount - IFNULL(amount_received, 0)'));
        $wholesaleCustomerIds = $wholesaleCustomerSales->pluck('customer_id')->unique();
        $paymentsReceivedViaWholesaleCustomers = \App\Models\Payment::whereIn('customer_id', $wholesaleCustomerIds);
        if ($from) $paymentsReceivedViaWholesaleCustomers->where('date', '>=', $from);
        if ($to) $paymentsReceivedViaWholesaleCustomers->where('date', '<=', $to);
        $paymentsReceivedViaWholesaleCustomers = $paymentsReceivedViaWholesaleCustomers->sum('amount_paid');
        $pendingBalance = $pendingBalanceSales - $shopkeeperPayments + $pendingWholesaleCustomer - $paymentsReceivedViaWholesaleCustomers;

        // Add opening outstanding to total sales and pending balance
        $openingOutstanding = \App\Models\ShopkeeperTransaction::where('type', 'product_sold')->where('description', 'Opening Outstanding')->sum('total_amount');
        $totalSales = $totalSales + $openingOutstanding;
        $pendingBalance = $pendingBalance + $openingOutstanding;

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
        // Use withTrashed to include soft-deleted shopkeepers in counts and aggregations
        $shopkeepersCount = \App\Models\Shopkeeper::withTrashed()->whereHas('distributor', function($q) use ($companyId) { $q->where('company_id', $companyId); })->count();
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
            'totalPurchasesPKR',
            'totalExternalPurchases',
            'totalExpenses',
            'inventoryCount',
            'accountsPayablePKR',
            'totalInternalSales',
            'totalExternalSales',
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

        // Purchases (use PKR-converted value)
        $totalPurchasesPKRQuery = \App\Models\Purchase::where('company_id', $companyId);
        if ($from) $totalPurchasesPKRQuery->where('created_at', '>=', $from);
        if ($to) $totalPurchasesPKRQuery->where('created_at', '<=', $to);
        $totalPurchases = $totalPurchasesPKRQuery->sum('pkr_amount');

        // Returns
        $returnsQuery = \App\Models\ReturnTransaction::whereHas('sale', function($q) use ($companyId, $from, $to) {
            $q->where('company_id', $companyId);
            if ($from) $q->where('created_at', '>=', $from);
            if ($to) $q->where('created_at', '<=', $to);
        });
        $totalReturns = $returnsQuery->sum(DB::raw('amount * quantity'));
        $returnItemsCount = $returnsQuery->sum('quantity');
        $netSale = $totalSales - $totalReturns;

        // Payments Received (sales + direct payments + shopkeeper payments)
        $paymentsReceivedViaSales = \App\Models\Sale::where('company_id', $companyId);
        if ($from) $paymentsReceivedViaSales->where('created_at', '>=', $from);
        if ($to) $paymentsReceivedViaSales->where('created_at', '<=', $to);
        $paymentsReceivedViaSales = $paymentsReceivedViaSales->get()->sum(function($sale) {
            if ($sale->sale_type === 'retail') {
                return ($sale->amount_received ?? 0) - ($sale->change_return ?? 0);
            } else {
                return $sale->amount_received ?? 0;
            }
        });
        $paymentsReceivedViaPayments = \App\Models\Payment::whereHas('customer', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        });
        if ($from) $paymentsReceivedViaPayments->where('date', '>=', $from);
        if ($to) $paymentsReceivedViaPayments->where('date', '<=', $to);
        $paymentsReceivedViaPayments = $paymentsReceivedViaPayments->sum('amount_paid');
        // Include soft-deleted shopkeepers in payments received calculation
        $shopkeeperIds = \App\Models\Shopkeeper::withTrashed()->pluck('id');
        $paymentsReceivedViaShopkeepers = \App\Models\ShopkeeperTransaction::where('type', 'payment_made')
            ->whereIn('shopkeeper_id', $shopkeeperIds);
        if ($from) $paymentsReceivedViaShopkeepers->where('transaction_date', '>=', $from);
        if ($to) $paymentsReceivedViaShopkeepers->where('transaction_date', '<=', $to);
        $paymentsReceivedViaShopkeepers = $paymentsReceivedViaShopkeepers->sum('total_amount');
        $paymentsReceived = $paymentsReceivedViaSales + $paymentsReceivedViaPayments + $paymentsReceivedViaShopkeepers;

        // Total received via direct payments (for this company)
        $totalReceivedViaPayments = \App\Models\Payment::whereHas('customer', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        });
        if ($from) $totalReceivedViaPayments->where('date', '>=', $from);
        if ($to) $totalReceivedViaPayments->where('date', '<=', $to);
        $totalReceivedViaPayments = $totalReceivedViaPayments->sum('amount_paid');
        // Total received via sales (wholesale/distributor)
        $totalReceivedViaSales = \App\Models\Sale::where('company_id', $companyId)
            ->whereIn('sale_type', ['wholesale', 'distributor']);
        if ($from) $totalReceivedViaSales->where('created_at', '>=', $from);
        if ($to) $totalReceivedViaSales->where('created_at', '<=', $to);
        $totalReceivedViaSales = $totalReceivedViaSales->sum('amount_received');
        // Pending balance (accounts receivable)
        $pendingBalance = $totalSales - ($totalReceivedViaSales + $totalReceivedViaPayments);

        // Add opening outstanding to total sales and pending balance
        $openingOutstanding = \App\Models\ShopkeeperTransaction::where('type', 'product_sold')->where('description', 'Opening Outstanding')->sum('total_amount');
        $totalSales = $totalSales + $openingOutstanding;
        $pendingBalance = $pendingBalance + $openingOutstanding;

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
        $shopkeepersCount = \App\Models\Shopkeeper::withTrashed()->whereHas('distributor', function($q) use ($companyId) { $q->where('company_id', $companyId); })->count();
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
