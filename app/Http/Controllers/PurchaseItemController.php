<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PurchaseItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeAdmin()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $items = PurchaseItem::all();
        return view('purchase_items.index', compact('items'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $purchases = Purchase::all();
        $inventories = Inventory::all();
        return view('purchase_items.create', compact('purchases', 'inventories'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'inventory_id' => 'required|exists:inventory,id',
            'quantity' => 'required|numeric|min:1',
            'purchase_amount' => 'required|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
        ]);

        PurchaseItem::create($validated);
        
        return redirect()->route('purchase-items.index')->with('success', 'Purchase item created successfully');
    }

    public function show(string $id)
    {
        $this->authorizeAdmin();
        $item = PurchaseItem::findOrFail($id);
        return view('purchase_items.show', compact('item'));
    }

    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $item = PurchaseItem::findOrFail($id);
        $purchases = Purchase::all();
        $inventories = Inventory::all();
        return view('purchase_items.edit', compact('item', 'purchases', 'inventories'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'inventory_id' => 'required|exists:inventory,id',
            'quantity' => 'required|numeric|min:1',
            'purchase_amount' => 'required|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
        ]);

        $item = PurchaseItem::findOrFail($id);
        $item->update($validated);
        
        return redirect()->route('purchase-items.index')->with('success', 'Purchase item updated successfully');
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $item = PurchaseItem::findOrFail($id);
        $item->delete();
        
        return redirect()->route('purchase-items.index')->with('success', 'Purchase item deleted successfully');
    }
}
