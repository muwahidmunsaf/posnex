<?php

namespace App\Http\Controllers;

use App\Models\ShopkeeperTransaction;
use App\Models\Shopkeeper;
use App\Models\Distributor;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ShopkeeperTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function authorizeAdmin()
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $transactions = ShopkeeperTransaction::all();
        return view('shopkeeper_transactions.index', compact('transactions'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $shopkeepers = Shopkeeper::all();
        $distributors = Distributor::all();
        $inventories = Inventory::all();
        return view('shopkeeper_transactions.create', compact('shopkeepers', 'distributors', 'inventories'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        // Only require fields needed for a payment
        $validated = $request->validate([
            'shopkeeper_id' => 'required|exists:shopkeepers,id',
            'distributor_id' => 'required|exists:distributors,id',
            'type' => 'required|in:payment_made',
            'total_amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed,cancelled',
        ]);
        // Default status to completed if not set
        if (empty($validated['status'])) {
            $validated['status'] = 'completed';
        }
        // Calculate commission for payment_made
        if ($validated['type'] === 'payment_made') {
            $shopkeeper = \App\Models\Shopkeeper::find($validated['shopkeeper_id']);
            $distributor = $shopkeeper ? $shopkeeper->distributor : null;
            $commissionRate = $distributor && $distributor->commission_rate ? $distributor->commission_rate : 0;
            $validated['commission_amount'] = round($validated['total_amount'] * $commissionRate / 100, 2);
        }
        ShopkeeperTransaction::create($validated);
        // Return a simple success for AJAX
        return response()->json(['success' => true]);
    }

    public function show(string $id)
    {
        $this->authorizeAdmin();
        $transaction = ShopkeeperTransaction::findOrFail($id);
        return view('shopkeeper_transactions.show', compact('transaction'));
    }

    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $transaction = ShopkeeperTransaction::findOrFail($id);
        $shopkeepers = Shopkeeper::all();
        $distributors = Distributor::all();
        $inventories = Inventory::all();
        return view('shopkeeper_transactions.edit', compact('transaction', 'shopkeepers', 'distributors', 'inventories'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        $validated = $request->validate([
            'shopkeeper_id' => 'required|exists:shopkeepers,id',
            'distributor_id' => 'required|exists:distributors,id',
            'inventory_id' => 'nullable|exists:inventory,id',
            'type' => 'required|in:product_received,product_sold,product_returned,payment_made',
            'quantity' => 'nullable|numeric|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        $transaction = ShopkeeperTransaction::findOrFail($id);
        // Recalculate commission if payment_made
        if ($validated['type'] === 'payment_made') {
            $shopkeeper = \App\Models\Shopkeeper::find($validated['shopkeeper_id']);
            $distributor = $shopkeeper ? $shopkeeper->distributor : null;
            $commissionRate = $distributor && $distributor->commission_rate ? $distributor->commission_rate : 0;
            $validated['commission_amount'] = round($validated['total_amount'] * $commissionRate / 100, 2);
        }
        $transaction->update($validated);
        // Return JSON for AJAX
        return response()->json(['success' => true]);
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $transaction = ShopkeeperTransaction::findOrFail($id);
        $transaction->delete();
        // Return JSON for AJAX
        return response()->json(['success' => true]);
    }
}
