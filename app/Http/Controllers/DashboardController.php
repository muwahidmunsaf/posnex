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

    public function index()
    {
        if (Auth::user()->role === 'employee') {
            abort(403, 'Unauthorized');
        }

        $companyId = Auth::user()->company_id;

        $internalSales = Sale::where('company_id', $companyId)->sum('total_amount');
        $externalSales = ExternalSale::where('company_id', $companyId)->sum('total_amount');
        $totalSales = $internalSales + $externalSales;

        // Combine internal + external purchases
        $internalPurchases = PurchaseItem::whereHas('purchase', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->sum(DB::raw('purchase_amount')); // Assuming these fields exist

        $externalPurchases = ExternalPurchase::where('company_id', $companyId)->sum('purchase_amount');
        $totalPurchases = $internalPurchases + $externalPurchases;

        $totalExpenses = Expense::where('company_id', $companyId)->sum('amount');
        $inventoryCount = Inventory::where('company_id', $companyId)->count();

        $totalInternalSales = Sale::where('company_id', $companyId)->sum('total_amount');
        $totalExternalSales = ExternalSale::where('company_id', $companyId)->sum('total_amount');
        $totalSales = $totalInternalSales + $totalExternalSales;

        $totalInternalPurchases = PurchaseItem::whereHas('purchase', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->sum(DB::raw('purchase_amount'));

        $totalExternalPurchases = ExternalPurchase::where('company_id', $companyId)->sum('purchase_amount');
        $totalPurchases = $totalInternalPurchases + $totalExternalPurchases;

        return view('dashboard', compact(
            'totalSales',
            'totalPurchases',
            'totalInternalSales',
            'totalExternalSales',
            'totalInternalPurchases',
            'totalExternalPurchases',
            'totalExpenses',
            'inventoryCount'
        ));
    }
}
