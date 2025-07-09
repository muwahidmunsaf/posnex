<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
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

        return view('purchases.create', compact('suppliers', 'inventories'));
    }

    public function store(Request $request)
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
            $items = $request->items;

            $totalAmount = collect($items)->sum('purchase_amount');

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $totalAmount,
                'company_id' => $companyId,
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
                $inventory->unit += $item['quantity'];
                $inventory->save();
            }

            DB::commit();

            return redirect()->route('purchase.index')->with('success', 'Purchase created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
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
                    $inventory->unit -= $oldItem->quantity;
                    $inventory->save();
                }
            }

            // Delete old purchase items
            $purchase->items()->delete();

            $items = $request->items;
            $totalAmount = collect($items)->sum('purchase_amount');

            // Update the purchase itself
            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $totalAmount,
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
                    $inventory->unit += $item['quantity'];
                    $inventory->save();
                }
            }

            DB::commit();

            return redirect()->route('purchase.index')->with('success', 'Purchase updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update purchase.'])->withInput();
        }
    }


    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchase.index')->with('success', 'Purchase deleted successfully.');
    }
}
