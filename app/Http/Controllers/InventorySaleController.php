<?php

namespace App\Http\Controllers;

use App\Models\InventorySale;
use App\Models\Sale;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventorySaleController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $inventorySales = InventorySale::with(['sale', 'item'])->paginate(20);
        return view('inventory-sales.index', compact('inventorySales'));
    }

    public function create()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $sales = Sale::all();
        $inventory = Inventory::all();
        return view('inventory-sales.create', compact('sales', 'inventory'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'item_id' => 'required|exists:inventory,id',
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'sale_type' => 'required|in:retail,wholesale',
        ]);

        // Get company_id from user or from the sale
        $companyId = Auth::user()->company_id;
        if (!$companyId) {
            $sale = Sale::find($validated['sale_id']);
            $companyId = $sale->company_id;
        }
        $validated['company_id'] = $companyId;

        InventorySale::create($validated);

        return redirect()->route('inventory-sales.index')->with('success', 'Inventory sale created successfully.');
    }

    public function show(InventorySale $inventorySale)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        return view('inventory-sales.show', compact('inventorySale'));
    }

    public function edit(InventorySale $inventorySale)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $sales = Sale::all();
        $inventory = Inventory::all();
        return view('inventory-sales.edit', compact('inventorySale', 'sales', 'inventory'));
    }

    public function update(Request $request, InventorySale $inventorySale)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'item_id' => 'required|exists:inventory,id',
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'sale_type' => 'required|in:retail,wholesale',
        ]);

        // Get company_id from user or from the sale
        $companyId = Auth::user()->company_id;
        if (!$companyId) {
            $sale = Sale::find($validated['sale_id']);
            $companyId = $sale->company_id;
        }
        $validated['company_id'] = $companyId;

        $inventorySale->update($validated);

        return redirect()->route('inventory-sales.index')->with('success', 'Inventory sale updated successfully.');
    }

    public function destroy(InventorySale $inventorySale)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $inventorySale->delete();

        return redirect()->route('inventory-sales.index')->with('success', 'Inventory sale deleted successfully.');
    }
} 