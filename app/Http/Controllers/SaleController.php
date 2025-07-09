<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\InventorySale;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class SaleController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $company = $user->company;

        // Fetch only active inventories with stock > 0
        $inventories = Inventory::where('company_id', $company->id)
            ->where('status', 'active')
            ->where('unit', '>', 0)
            ->get();
        // Only fetch wholesale customers
        $customers = Customer::where('company_id', $company->id)
            ->where('type', 'wholesale')
            ->get();
        return view('sales.create', compact('inventories', 'company', 'customers'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        // Accept either wholesale_customer_id or retail_customer_name
        $request->validate([
            'items' => 'required|array',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity' => 'required|integer|min:1',
            'sale_type' => 'required_if:company.type,both|in:retail,wholesale',
            'payment_method' => 'required|in:cash,card,online',
            'discount' => 'nullable|numeric|min:0',
            // Custom validation: one of the two must be present, not both
            'wholesale_customer_id' => 'nullable|exists:customers,id',
            'retail_customer_name' => 'nullable|string|max:255',
        ]);
        if (!$request->wholesale_customer_id && !$request->retail_customer_name) {
            return back()->withErrors(['Please select a wholesale customer or enter a retail customer name.'])->withInput();
        }
        if ($request->wholesale_customer_id && $request->retail_customer_name) {
            return back()->withErrors(['Please fill only one: either select a wholesale customer or enter a retail customer name, not both.'])->withInput();
        }

        $discount = $request->discount ?? 0;

        $subtotal = 0;
        $inventorySales = [];

        foreach ($request->items as $item) {
            $inventory = Inventory::findOrFail($item['inventory_id']);

            $amount = $request->sale_type === 'retail' ? $inventory->retail_amount : $inventory->wholesale_amount;
            $totalAmount = $amount * $item['quantity'];

            $inventorySales[] = [
                'inventory' => $inventory,
                'item_id' => $inventory->id,
                'quantity' => $item['quantity'],
                'sale_type' => $request->sale_type,
                'amount' => $amount,
                'total_amount' => $totalAmount
            ];

            $subtotal += $totalAmount;
        }

        $subtotalAfterDiscount = $subtotal - $discount;

        $taxField = 'tax' . ucfirst($request->payment_method); // taxCash, taxCard, taxOnline
        $tax_percentage = $company->$taxField ?? 0;
        $tax_amount = ($tax_percentage / 100) * $subtotalAfterDiscount;
        $total_amount = $subtotalAfterDiscount + $tax_amount;

        // Generate custom sale_code
        $prefix = strtoupper(substr($company->name, 0, 1));
        $companyIdPadded = str_pad($company->id, 3, '0', STR_PAD_LEFT);

        // Count existing sales for this company
        $saleCount = Sale::where('company_id', $company->id)->count() + 1;
        $saleNumber = str_pad($saleCount, 5, '0', STR_PAD_LEFT);

        $saleCode = "{$prefix}{$companyIdPadded}-{$saleNumber}";

        $saleData = [
            'sale_code' => $saleCode,
            'created_by' => $user->name,
            'discount' => $discount,
            'subtotal' => $subtotalAfterDiscount,
            'payment_method' => $request->payment_method,
            'tax_percentage' => $tax_percentage,
            'tax_amount' => $tax_amount,
            'total_amount' => $total_amount,
            'company_id' => $company->id,
            'sale_type' => $request->sale_type,
        ];
        if ($request->wholesale_customer_id) {
            $saleData['customer_id'] = $request->wholesale_customer_id;
            $saleData['customer_name'] = null;
        } else {
            $saleData['customer_id'] = null;
            $saleData['customer_name'] = $request->retail_customer_name;
        }
        // Save amount_received and change_return if present
        if ($request->has('amount_received')) {
            $saleData['amount_received'] = $request->amount_received;
        }
        if ($request->has('change_return')) {
            $saleData['change_return'] = $request->change_return;
        }

        $sale = Sale::create($saleData);

        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'action' => 'Created Sale',
            'details' => 'Sale Code: ' . $sale->sale_code . ', Customer: ' . ($sale->customer->name ?? $sale->customer_name) . ', Amount: ' . $sale->total_amount,
        ]);

        foreach ($inventorySales as $data) {
            InventorySale::create([
                'sale_id' => $sale->id,
                'item_id' => $data['item_id'],
                'quantity' => $data['quantity'],
                'sale_type' => $data['sale_type'],
                'amount' => $data['amount'],
                'total_amount' => $data['total_amount'],
                'company_id' => $company->id,
            ]);

            $data['inventory']->decrement('unit', $data['quantity']);
        }

        return view('sales.after-sale', ['saleId' => $sale->id]);
    }



    public function index(Request $request)
    {
        $query = Sale::with('customer') // eager load customer
            ->where('company_id', Auth::user()->company_id);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_code', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($subQuery) use ($request) {
                        $subQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $sales = $query->latest()->paginate(10);

        return view('sales.index', compact('sales'));
    }


    public function print($id)
    {
        $sale = Sale::with('inventorySales.item') // eager load items
            ->where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();

        return view('sales.print', compact('sale'));
    }

    public function returnForm($id)
    {
        $sale = Sale::with('inventorySales.item')->where('id', $id)->firstOrFail();
        return view('sales.return', compact('sale'));
    }

    public function processReturn(Request $request, $id)
    {
        $sale = Sale::with('inventorySales')->findOrFail($id);
        $user = auth()->user();
        $returns = $request->input('returns', []);
        $anyReturn = false;
        foreach ($returns as $detailId => $data) {
            $qty = intval($data['quantity'] ?? 0);
            if ($qty > 0) {
                $anyReturn = true;
                // Update inventory (add returned qty)
                $itemId = $data['item_id'];
                $amount = $data['amount'];
                $reason = $data['reason'] ?? null;
                $inventory = \App\Models\Inventory::find($itemId);
                if ($inventory) {
                    $inventory->increment('unit', $qty);
                }
                // Record return transaction
                \App\Models\ReturnTransaction::create([
                    'sale_id' => $sale->id,
                    'item_id' => $itemId,
                    'quantity' => $qty,
                    'amount' => $amount,
                    'reason' => $reason,
                    'processed_by' => $user->name,
                ]);
            }
        }
        if ($anyReturn) {
            \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'action' => 'Processed Return',
                'details' => 'Sale ID: ' . $sale->id . ', Customer: ' . ($sale->customer->name ?? $sale->customer_name),
            ]);
            return redirect()->route('sales.index')->with('success', 'Return processed successfully.');
        } else {
            return back()->withErrors(['Please enter a return quantity for at least one item.']);
        }
    }
}
