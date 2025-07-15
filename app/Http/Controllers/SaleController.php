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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class SaleController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        $distributors = \App\Models\Distributor::where('company_id', $company->id)->get();
        $inventories = \App\Models\Inventory::where('company_id', $company->id)->get();
        $shopkeepers = \App\Models\Shopkeeper::where('distributor_id', $distributors->pluck('id'))->get();
        $customers = \App\Models\Customer::where('company_id', $company->id)->get();
        // Generate idempotency token
        $token = Str::uuid()->toString();
        Session::put('sale_idempotency_token', $token);
        return view('sales.create', compact('distributors', 'inventories', 'shopkeepers', 'customers', 'token'));
    }


    public function store(Request $request)
    {
        // Idempotency token check
        $token = $request->input('idempotency_token');
        $sessionToken = Session::get('sale_idempotency_token');
        if (!$token || $token !== $sessionToken) {
            return back()->withErrors(['error' => 'Invalid or missing submission token. Please try again.'])->withInput();
        }
        // Consume token
        Session::forget('sale_idempotency_token');

        $user = Auth::user();
        $company = $user->company;

        $saleType = $request->input('sale_type');
        // Validation based on sale type
        $hasItems = $request->has('items') && is_array($request->items) && count($request->items) > 0;
        $hasManual = $request->has('manual_products') && is_array($request->manual_products) && count($request->manual_products) > 0;
        if (!$hasItems && !$hasManual) {
            return back()->withErrors(['You must add at least one product (inventory or manual).'])->withInput();
        }
        $rules = [
            'items' => 'array',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,online',
            'discount' => 'nullable|numeric|min:0',
            'manual_products' => 'array',
            'manual_products.*.name' => 'required_with:manual_products|string|max:255',
            'manual_products.*.quantity' => 'required_with:manual_products|integer|min:1',
            'manual_products.*.selling_price' => 'required_with:manual_products|numeric|min:0',
            'manual_products.*.purchase_price' => 'required_with:manual_products|numeric|min:0',
            'manual_products.*.buy_from' => 'nullable|string|max:255',
        ];
        if ($saleType === 'distributor') {
            $rules['distributor_id'] = 'required|exists:distributors,id';
            $rules['shopkeeper_id'] = 'required|exists:shopkeepers,id';
        } elseif ($saleType === 'wholesale') {
            $rules['wholesale_customer_id'] = 'required|exists:customers,id';
        } elseif ($saleType === 'retail') {
            $rules['retail_customer_name'] = 'required|string|max:255';
        }
        $request->validate($rules);

        $discount = $request->discount ?? 0;
        $subtotal = 0;
        $inventorySales = [];

        $items = $request->items ?? [];
        $manualProducts = $request->manual_products ?? [];

        foreach ($items as $item) {
            $inventory = Inventory::findOrFail($item['inventory_id']);
            $amount = ($saleType === 'distributor' || $request->shopkeeper_id) ? $inventory->wholesale_amount : (($saleType === 'retail') ? $inventory->retail_amount : $inventory->wholesale_amount);
            $totalAmount = $amount * $item['quantity'];
            $inventorySales[] = [
                'inventory' => $inventory,
                'item_id' => $inventory->id,
                'quantity' => $item['quantity'],
                'sale_type' => $saleType,
                'amount' => $amount,
                'total_amount' => $totalAmount
            ];
            $subtotal += $totalAmount;
        }

        // Add manual products to subtotal (for invoice, but not inventory sales)
        foreach ($manualProducts as $mp) {
            $subtotal += $mp['selling_price'] * $mp['quantity'];
        }

        $subtotalAfterDiscount = $subtotal - $discount;
        $taxField = 'tax' . ucfirst($request->payment_method); // taxCash, taxCard, taxOnline
        $tax_percentage = $company->$taxField ?? 0;
        $tax_amount = ($tax_percentage / 100) * $subtotalAfterDiscount;
        $total_amount = $subtotalAfterDiscount + $tax_amount;

        // Generate custom sale_code
        $prefix = strtoupper(substr($company->name, 0, 1));
        $companyIdPadded = str_pad($company->id, 3, '0', STR_PAD_LEFT);
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
            'sale_type' => $saleType,
        ];
        if ($saleType === 'distributor') {
            $saleData['distributor_id'] = $request->distributor_id;
            $saleData['shopkeeper_id'] = $request->shopkeeper_id;
            $saleData['customer_id'] = null;
            $saleData['customer_name'] = null;
        } elseif ($saleType === 'wholesale') {
            $saleData['customer_id'] = $request->wholesale_customer_id;
            $saleData['customer_name'] = null;
            $saleData['distributor_id'] = null;
            $saleData['shopkeeper_id'] = null;
        } elseif ($saleType === 'retail') {
            $saleData['customer_id'] = null;
            $saleData['customer_name'] = $request->retail_customer_name;
            $saleData['distributor_id'] = null;
            $saleData['shopkeeper_id'] = null;
        }
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
            // Decrement inventory unit (ensure int)
            $unit = (int) $data['inventory']->unit;
            $quantity = (int) $data['quantity'];
            $data['inventory']->unit = $unit; // ensure type
            $data['inventory']->decrement('unit', $quantity);
        }

        // --- Manual/External Sale Logic ---
        foreach ($manualProducts as $mp) {
            // Generate unique external purchase ID
            $prefixE = strtoupper(substr($company->name, 0, 1)) . str_pad($company->id, 3, '0', STR_PAD_LEFT);
            $lastEP = \App\Models\ExternalPurchase::where('purchaseE_id', 'like', "$prefixE-%")->latest('id')->first();
            $serial = $lastEP ? intval(substr($lastEP->purchaseE_id, -5)) + 1 : 1;
            $purchaseE_id = "$prefixE-" . str_pad($serial, 5, '0', STR_PAD_LEFT);

            $purchase = \App\Models\ExternalPurchase::create([
                'purchaseE_id' => $purchaseE_id,
                'item_name' => $mp['name'],
                'details' => null,
                'purchase_amount' => $mp['purchase_price'],
                'purchase_source' => $mp['buy_from'] ?? null,
                'company_id' => $company->id,
                'created_by' => $user->name,
                'parent_sale_id' => $sale->id,
            ]);
            
            // Debug log for purchase
            \Log::info('Manual Product Purchase Created', [
                'sale_id' => $sale->id,
                'purchase' => $purchase,
            ]);

            // Generate unique external sale ID
            $lastES = \App\Models\ExternalSale::where('saleE_id', 'like', "$prefixE-%")->latest('id')->first();
            $serialSale = $lastES ? intval(substr($lastES->saleE_id, -5)) + 1 : 1;
            $saleE_id = "$prefixE-" . str_pad($serialSale, 5, '0', STR_PAD_LEFT);

            // Tax for manual product
            $taxField = 'tax' . ucfirst($request->payment_method);
            $taxPercentage = $company->$taxField ?? 0;
            $taxAmount = ($taxPercentage / 100) * ($mp['selling_price'] * $mp['quantity']);
            $totalAmount = ($mp['selling_price'] * $mp['quantity']) + $taxAmount;

            // For external/manual sale, set customer_id if available, else null
            $externalCustomerId = null;
            if ($sale->customer_id) {
                $externalCustomerId = $sale->customer_id;
            } elseif ($saleType === 'retail') {
                $externalCustomerId = null; // or set to a default retail customer if needed
            }
            
            $externalSale = \App\Models\ExternalSale::create([
                'saleE_id' => $saleE_id,
                'purchaseE_id' => $purchaseE_id,
                'sale_amount' => $mp['selling_price'] * $mp['quantity'],
                'payment_method' => $request->payment_method,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'customer_id' => $externalCustomerId,
                'company_id' => $company->id,
                'created_by' => $user->name,
                'parent_sale_id' => $sale->id,
            ]);
            // Debug log for external sale
            \Log::info('Manual Product External Sale Created', [
                'sale_id' => $sale->id,
                'external_sale' => $externalSale,
            ]);
        }

        // Refresh sale and fetch manual/external products for invoice
        $sale->refresh();
        $externalProducts = collect();
        $externalSales = \App\Models\ExternalSale::where('parent_sale_id', $sale->id)->get();
        foreach ($externalSales as $extSale) {
            $purchase = \App\Models\ExternalPurchase::where('purchaseE_id', $extSale->purchaseE_id)
                ->where('parent_sale_id', $sale->id)->first();
            if ($purchase) {
                $externalProducts->push([
                    'name' => $purchase->item_name,
                    'quantity' => 1,
                    'rate' => $extSale->sale_amount,
                    'amount' => $extSale->sale_amount,
                ]);
            }
        }

        // Show professional invoice for distributor/wholesale, current for retail
        if ($saleType === 'retail') {
            return view('sales.print', compact('sale', 'externalProducts'));
        } else {
            $distributor = $sale->distributor ?? null;
            $shopkeeper = $sale->shopkeeper ?? null;
            $customer = $sale->customer ?? null;
            $company = $company;
            $amountReceived = $sale->amount_received ?? 0;
            if ($saleType === 'distributor' && $shopkeeper) {
                $previousOutstanding = $shopkeeper->outstanding_balance - $sale->total_amount + $amountReceived;
                $newOutstanding = $shopkeeper->outstanding_balance;
            } elseif ($saleType === 'wholesale' && $customer) {
                $previousOutstanding = $customer->outstanding_balance - $sale->total_amount + $amountReceived;
                $newOutstanding = $customer->outstanding_balance;
            } else {
                $previousOutstanding = 0;
                $newOutstanding = 0;
            }
            return view('sales.professional_invoice', compact('sale', 'distributor', 'shopkeeper', 'customer', 'company', 'previousOutstanding', 'newOutstanding', 'amountReceived', 'externalProducts'));
        }
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
        $sale = Sale::with(['inventorySales.item', 'distributor', 'shopkeeper', 'customer']) // eager load all needed
            ->where('id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->firstOrFail();
        // Fetch manual/external products for this sale
        $externalProducts = collect();
        $externalSales = \App\Models\ExternalSale::where('parent_sale_id', $sale->id)->get();
        foreach ($externalSales as $extSale) {
            $purchase = \App\Models\ExternalPurchase::where('purchaseE_id', $extSale->purchaseE_id)->where('parent_sale_id', $sale->id)->first();
            if ($purchase) {
                $externalProducts->push([
                    'name' => $purchase->item_name,
                    'quantity' => 1, // Manual products are always single quantity per record
                    'rate' => $extSale->sale_amount,
                    'amount' => $extSale->sale_amount,
                ]);
            }
        }
        if ($sale->sale_type === 'retail') {
            return view('sales.print', compact('sale', 'externalProducts'));
        } else {
            $distributor = $sale->distributor ?? null;
            $shopkeeper = $sale->shopkeeper ?? null;
            $customer = $sale->customer ?? null;
            $company = $sale->company;
            $amountReceived = $sale->amount_received ?? 0;
            if ($sale->sale_type === 'distributor' && $shopkeeper) {
                $previousOutstanding = $shopkeeper->outstanding_balance - $sale->total_amount + $amountReceived;
                $newOutstanding = $shopkeeper->outstanding_balance;
            } elseif ($sale->sale_type === 'wholesale' && $customer) {
                $previousOutstanding = $customer->outstanding_balance - $sale->total_amount + $amountReceived;
                $newOutstanding = $customer->outstanding_balance;
            } else {
                $previousOutstanding = 0;
                $newOutstanding = 0;
            }
            return view('sales.professional_invoice', compact('sale', 'distributor', 'shopkeeper', 'customer', 'company', 'previousOutstanding', 'newOutstanding', 'amountReceived', 'externalProducts'));
        }
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

    public function edit($id)
    {
        $sale = Sale::with(['inventorySales', 'distributor', 'shopkeeper', 'customer', 'manualProducts'])->findOrFail($id);
        $inventories = Inventory::where('company_id', $sale->company_id)->where('status', 'active')->get();
        $customers = Customer::where('company_id', $sale->company_id)->get();
        $distributors = \App\Models\Distributor::all();
        $shopkeepers = \App\Models\Shopkeeper::all();
        return view('sales.edit', compact('sale', 'inventories', 'customers', 'distributors', 'shopkeepers'));
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        // You can add validation and update logic here similar to store()
        // For now, just allow updating payment_method, discount, amount_received, change_return
        $data = $request->validate([
            'payment_method' => 'required|in:cash,card,online',
            'discount' => 'nullable|numeric|min:0',
            'amount_received' => 'nullable|numeric|min:0',
            'change_return' => 'nullable|numeric|min:0',
        ]);
        $sale->update($data);
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        // Delete related manual/external sales and purchases linked to this sale
        $externalSales = \App\Models\ExternalSale::where('parent_sale_id', $sale->id)->get();
        foreach ($externalSales as $extSale) {
            $purchase = \App\Models\ExternalPurchase::where('purchaseE_id', $extSale->purchaseE_id)->first();
            if ($purchase) {
                $purchase->delete();
            }
            $extSale->delete();
        }
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
