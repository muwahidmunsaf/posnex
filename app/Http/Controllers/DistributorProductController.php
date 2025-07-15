<?php

namespace App\Http\Controllers;

use App\Models\DistributorProduct;
use App\Models\Distributor;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DistributorProductController extends Controller
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
        $products = DistributorProduct::all();
        return view('distributor_products.index', compact('products'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $distributors = Distributor::all();
        $inventories = Inventory::all();
        return view('distributor_products.create', compact('distributors', 'inventories'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'inventory_id' => 'required|exists:inventory,id',
            'quantity_assigned' => 'required|numeric|min:1',
            'quantity_remaining' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'total_value' => 'required|numeric|min:0',
            'assignment_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
            'assignment_number' => 'required|string|unique:distributor_products',
        ]);

        DistributorProduct::create($validated);
        
        return redirect()->route('distributor-products.index')->with('success', 'Distributor product created successfully');
    }

    public function show(string $id)
    {
        $this->authorizeAdmin();
        $product = DistributorProduct::findOrFail($id);
        return view('distributor_products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $product = DistributorProduct::findOrFail($id);
        $distributors = Distributor::all();
        $inventories = Inventory::all();
        return view('distributor_products.edit', compact('product', 'distributors', 'inventories'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'inventory_id' => 'required|exists:inventory,id',
            'quantity_assigned' => 'required|numeric|min:1',
            'quantity_remaining' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'total_value' => 'required|numeric|min:0',
            'assignment_date' => 'required|date',
            'status' => 'required|in:active,completed,cancelled',
            'assignment_number' => 'required|string|unique:distributor_products,assignment_number,' . $id,
        ]);

        $product = DistributorProduct::findOrFail($id);
        $product->update($validated);
        
        return redirect()->route('distributor-products.index')->with('success', 'Distributor product updated successfully');
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $product = DistributorProduct::findOrFail($id);
        $product->delete();
        
        return redirect()->route('distributor-products.index')->with('success', 'Distributor product deleted successfully');
    }

    public function printReceipt(string $id)
    {
        $this->authorizeAdmin();
        $product = DistributorProduct::findOrFail($id);
        return view('distributor_products.print_receipt', compact('product'));
    }
}
