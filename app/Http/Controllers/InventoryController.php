<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with(['category', 'supplier'])
            ->where('company_id', Auth::user()->company_id);

        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        $inventories = $query->latest()->paginate(10)->appends($request->query());

        return view('inventory.index', compact('inventories'));
    }

    public function status()
    {
        $inventories = Inventory::where('company_id', Auth::user()->company_id)->get();

        return view('inventory.status', compact('inventories'));
    }


    public function create()
    {
        $categories = Category::where('company_id', Auth::user()->company_id)->get();
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();
        return view('inventory.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'retail_amount' => 'required|numeric',
            'wholesale_amount' => 'nullable|numeric',
            'details' => 'required|string',
            'unit' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'item_name',
            'retail_amount',
            'wholesale_amount',
            'details',
            'unit',
            'barcode',
            'sku',
            'status',
            'supplier_id',
            'category_id'
        ]);

        $data['company_id'] = Auth::user()->company_id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('inventory_images', 'public');
        }

        Inventory::create($data);

        return redirect()->route('inventory.index')->with('success', 'Item added successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Inventory $inventory)
    {
        $categories = Category::where('company_id', Auth::user()->company_id)->get();
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();
        return view('inventory.edit', compact('inventory', 'categories', 'suppliers'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'retail_amount' => 'required|numeric',
            'wholesale_amount' => 'nullable|numeric',
            'details' => 'required|string',
            'unit' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'item_name',
            'retail_amount',
            'wholesale_amount',
            'details',
            'unit',
            'barcode',
            'sku',
            'status',
            'supplier_id',
            'category_id'
        ]);

        $data['company_id'] = Auth::user()->company_id;

        if ($request->hasFile('image')) {
            // Optionally delete the old image
            if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
                Storage::disk('public')->delete($inventory->image);
            }
            $data['image'] = $request->file('image')->store('inventory_images', 'public');
        }

        $inventory->update($data);

        return redirect()->route('inventory.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
            Storage::disk('public')->delete($inventory->image);
        }

        $inventory->delete();
        return back()->with('success', 'Item deleted successfully.');
    }

    public function toggleStatus(Request $request, Inventory $inventory)
    {
        $inventory->status = $request->status === 'active' ? 'active' : 'inactive';
        $inventory->save();

        return response()->json([
            'success' => true,
            'status' => $inventory->status,
            'status_label' => ucfirst($inventory->status),
        ]);
    }
}
