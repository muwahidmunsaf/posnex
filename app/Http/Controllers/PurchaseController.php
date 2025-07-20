<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
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

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();
        $inventories = Inventory::where('company_id', Auth::user()->company_id)->get();
        // Generate idempotency token
        $token = Str::uuid()->toString();
        Session::put('purchase_idempotency_token', $token);
        return view('purchases.create', compact('suppliers', 'inventories', 'token'));
    }

    public function store(Request $request)
    {
        // Idempotency token check
        $token = $request->input('idempotency_token');
        $sessionToken = Session::get('purchase_idempotency_token');
        if (!$token || $token !== $sessionToken) {
            return back()->withErrors(['error' => 'Invalid or missing submission token. Please try again.'])->withInput();
        }
        // Consume token
        Session::forget('purchase_idempotency_token');

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.purchase_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $companyId = Auth::user()->company_id;

            // Define supplier, currencyCode, and exchangeRate before use
            $supplier = Supplier::findOrFail($request->supplier_id);
            $currencyCode = $supplier->currency['code'] ?? 'USD';
            $exchangeRate = $request->exchange_rate_to_pkr;
            if (!$exchangeRate || $exchangeRate <= 0) {
            $exchangeRate = Supplier::getCurrencyRateToPKR($currencyCode);
            }
            $exchangeRate = (float) $exchangeRate;
            Log::debug('PurchaseController: currencyCode', ['currencyCode' => $currencyCode]);
            Log::debug('PurchaseController: exchangeRate', ['exchangeRate' => $exchangeRate, 'type' => gettype($exchangeRate)]);

            $items = collect($request->items)->map(function($item) {
                $item['quantity'] = (int) $item['quantity'];
                $item['purchase_amount'] = (float) $item['purchase_amount'];
                return $item;
            });
            Log::debug('PurchaseController: items', ['items' => $items]);
            $totalAmount = (float) $items->sum(function($item) { return (float) $item['purchase_amount']; });
            Log::debug('PurchaseController: totalAmount', ['totalAmount' => $totalAmount, 'type' => gettype($totalAmount)]);
            $pkrAmount = (float) $totalAmount * (float) $exchangeRate;

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $totalAmount,
                'company_id' => $companyId,
                'currency_code' => $currencyCode,
                'exchange_rate_to_pkr' => $exchangeRate,
                'pkr_amount' => $pkrAmount,
            ]);

            foreach ($items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity' => $item['quantity'],
                    'purchase_amount' => $item['purchase_amount'],
                    'company_id' => $companyId,
                ]);

                // Update Inventory Quantity
                $inventory = Inventory::find($item['inventory_id']);
                $inventory->unit = (int) $inventory->unit + (int) $item['quantity'];
                $inventory->save();
            }

            // Log the activity
            $this->logCreate($purchase, 'Purchase', 'Supplier: ' . $supplier->supplier_name . ', Amount: ' . $totalAmount);

            DB::commit();

            return redirect()->route('purchase.index')->with('success', 'Purchase created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PurchaseController@store exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return back()->withErrors(['error' => 'Failed to create purchase.'])->withInput();
        }
    }

    public function edit($id)
    {
        $companyId = Auth::user()->company_id;

        $purchase = Purchase::where('company_id', $companyId)->with('items')->findOrFail($id);
        $suppliers = Supplier::where('company_id', $companyId)->get();
        $inventories = Inventory::where('company_id', $companyId)->get();

        return view('purchases.edit', compact('purchase', 'suppliers', 'inventories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.purchase_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $companyId = Auth::user()->company_id;

            $purchase = Purchase::where('company_id', $companyId)->findOrFail($id);

            // Rollback inventory quantities from existing items
            foreach ($purchase->items as $oldItem) {
                $inventory = Inventory::find($oldItem->inventory_id);
                if ($inventory && $inventory->company_id === $companyId) {
                    $inventory->unit = (int) $inventory->unit - (int) $oldItem->quantity;
                    $inventory->save();
                }
            }

            // Delete old purchase items
            $purchase->items()->delete();

            // In update method, do the same: move $supplier, $currencyCode, $exchangeRate before any use
            $supplier = Supplier::findOrFail($request->supplier_id);
            $currencyCode = $supplier->currency['code'] ?? 'USD';
            $exchangeRate = $request->exchange_rate_to_pkr;
            if (!$exchangeRate || $exchangeRate <= 0) {
            $exchangeRate = Supplier::getCurrencyRateToPKR($currencyCode);
            }
            $exchangeRate = (float) $exchangeRate;
            Log::debug('PurchaseController (update): currencyCode', ['currencyCode' => $currencyCode]);
            Log::debug('PurchaseController (update): exchangeRate', ['exchangeRate' => $exchangeRate, 'type' => gettype($exchangeRate)]);

            $items = collect($request->items)->map(function($item) {
                $item['quantity'] = (int) $item['quantity'];
                $item['purchase_amount'] = (float) $item['purchase_amount'];
                return $item;
            });
            Log::debug('PurchaseController (update): items', ['items' => $items]);
            $totalAmount = (float) $items->sum(function($item) { return (float) $item['purchase_amount']; });
            Log::debug('PurchaseController (update): totalAmount', ['totalAmount' => $totalAmount, 'type' => gettype($totalAmount)]);
            $pkrAmount = (float) $totalAmount * (float) $exchangeRate;

            // Update the purchase itself
            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $totalAmount,
                'currency_code' => $currencyCode,
                'exchange_rate_to_pkr' => $exchangeRate,
                'pkr_amount' => $pkrAmount,
            ]);

            // Create new purchase items and update inventory
            foreach ($items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity' => $item['quantity'],
                    'purchase_amount' => $item['purchase_amount'],
                    'company_id' => $companyId,
                ]);

                $inventory = Inventory::find($item['inventory_id']);
                if ($inventory && $inventory->company_id === $companyId) {
                    $inventory->unit = (int) $inventory->unit + (int) $item['quantity'];
                    $inventory->save();
                }
            }

            // Log the activity
            $this->logUpdate($purchase, 'Purchase', 'Supplier: ' . $supplier->supplier_name . ', Amount: ' . $totalAmount);

            DB::commit();

            return redirect()->route('purchase.index')->with('success', 'Purchase updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PurchaseController@update exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Failed to update purchase.'])->withInput();
        }
    }

    public function destroy(Purchase $purchase)
    {
        // Log the activity before deletion
        $this->logDelete($purchase, 'Purchase', 'Supplier: ' . ($purchase->supplier->supplier_name ?? '-') . ', Amount: ' . $purchase->total_amount);
        
        $purchase->delete();
        return redirect()->route('purchase.index')->with('success', 'Purchase deleted successfully.');
    }

    public function print($id)
    {
        $companyId = Auth::user()->company_id;
        $purchase = Purchase::where('company_id', $companyId)
            ->with(['supplier', 'items.inventory'])
            ->findOrFail($id);
        $company = Auth::user()->company;
        // Calculate previous payable (before this purchase)
        $supplier = $purchase->supplier;
        $previousPurchases = $supplier->purchases()
            ->where('company_id', $companyId)
            ->where('id', '<', $purchase->id)
            ->sum('total_amount');
        $previousPayments = $supplier->supplierPayments()
            ->where('payment_date', '<', $purchase->purchase_date)
            ->sum('amount');
        $previousPayable = max($previousPurchases - $previousPayments, 0);
        // Calculate grand total
        $grandTotal = 0;
        foreach ($purchase->items as $item) {
            $grandTotal += $item->purchase_amount;
        }
        $grandTotalWithPrevious = $grandTotal + $previousPayable;
        
        // Log the activity
        $this->logExport('Purchase Invoice', 'PDF');
        
        return view('purchases.print', compact('purchase', 'company', 'previousPayable', 'grandTotalWithPrevious'));
    }
}
