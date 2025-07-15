<?php

namespace App\Http\Controllers;

use App\Models\ExternalPurchase;
use App\Models\ExternalSale;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExternalSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $companyId = Auth::user()->company_id;
        $externalSales = ExternalSale::whereHas('purchase', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })->with('purchase')->latest()->paginate(10);

        return view('external_sales.index', compact('externalSales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $user = Auth::user();
        $company = $user->company;

        $customers = Customer::where('company_id', $company->id)
            ->where(function ($query) use ($company) {
                $query->where('type', $company->type);
                if ($company->type === 'both') {
                    $query->orWhere('type', 'retail')->orWhere('type', 'wholesale');
                }
            })->get();

        return view('external_sales.create', [
            'customers' => $customers,
            'taxes' => [
                'cash' => $company->taxCash ?? 0,
                'card' => $company->taxCard ?? 0,
                'online' => $company->taxOnline ?? 0,
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $user = Auth::user();
        $company = $user->company;
        $paymentMethod = $request->payment_method ?? 'cash';

        $request->validate([
            'item_name' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'purchase_amount' => 'nullable|numeric|min:0',
            'purchase_source' => 'nullable|string|max:255',
            'sale_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,online',
            'customer_id' => 'required|exists:customers,id',
        ]);

        // Generate unique external purchase ID
        $prefix = strtoupper(substr($company->name, 0, 1)) . str_pad($company->id, 3, '0', STR_PAD_LEFT);
        $lastEP = ExternalPurchase::where('purchaseE_id', 'like', "$prefix-%")->latest('id')->first();
        $serial = $lastEP ? intval(substr($lastEP->purchaseE_id, -5)) + 1 : 1;
        $purchaseE_id = "$prefix-" . str_pad($serial, 5, '0', STR_PAD_LEFT);

        // Create external purchase
        $purchase = ExternalPurchase::create([
            'purchaseE_id' => $purchaseE_id,
            'item_name' => $request->item_name ?? 'Test Item',
            'details' => $request->details,
            'purchase_amount' => $request->purchase_amount ?? $request->sale_amount,
            'purchase_source' => $request->purchase_source,
            'company_id' => $company->id,
            'created_by' => $user->name,
        ]);

        // Tax
        $taxField = 'tax' . ucfirst($paymentMethod); // e.g., taxCash
        $taxPercentage = $company->$taxField ?? 0;
        $taxAmount = ($taxPercentage / 100) * $request->sale_amount;
        $totalAmount = $request->sale_amount + $taxAmount;

        // Generate unique external sale ID
        $lastES = ExternalSale::where('saleE_id', 'like', "$prefix-%")->latest('id')->first();
        $serialSale = $lastES ? intval(substr($lastES->saleE_id, -5)) + 1 : 1;
        $saleE_id = "$prefix-" . str_pad($serialSale, 5, '0', STR_PAD_LEFT);

        // Create external sale
        $sale = ExternalSale::create([
            'saleE_id' => $saleE_id,
            'purchaseE_id' => $purchaseE_id,
            'sale_amount' => $request->sale_amount,
            'payment_method' => $paymentMethod,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'customer_id' => $request->customer_id,
            'company_id' => $company->id,
            'created_by' => $user->name,
        ]);

        return redirect()->route('external-sales.index')->with('success', 'External sale created successfully.');
    }

    public function invoice($id)
    {
        $sale = ExternalSale::with(['purchase', 'customer'])->findOrFail($id);
        return view('external_sales.invoice', compact('sale'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $user = Auth::user();
        $company = $user->company;
        $sale = ExternalSale::with('purchase')->findOrFail($id);
        $purchase = $sale->purchase;
        $customers = Customer::where('company_id', $company->id)
            ->where(function ($query) use ($company) {
                $query->where('type', $company->type);
                if ($company->type === 'both') {
                    $query->orWhere('type', 'retail')->orWhere('type', 'wholesale');
                }
            })->get();
        $taxes = [
            'cash' => $company->taxCash ?? 0,
            'card' => $company->taxCard ?? 0,
            'online' => $company->taxOnline ?? 0,
        ];
        return view('external_sales.edit', compact('sale', 'purchase', 'customers', 'taxes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $sale = ExternalSale::with('purchase')->findOrFail($id);
        $purchase = $sale->purchase;

        $request->validate([
            'item_name' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'sale_amount' => 'required|numeric|min:0',
            'purchase_amount' => 'nullable|numeric|min:0',
            'purchase_source' => 'nullable|string|max:255',
        ]);

        // Update purchase
        if ($purchase) {
            $purchase->item_name = $request->item_name ?? $purchase->item_name;
            $purchase->purchase_amount = $request->purchase_amount ?? $purchase->purchase_amount;
            $purchase->purchase_source = $request->purchase_source ?? $purchase->purchase_source;
            $purchase->save();
        }

        // Update sale
        $sale->sale_amount = $request->sale_amount;
        $sale->total_amount = $request->sale_amount + $sale->tax_amount; // keep tax as is
        $sale->save();

        return redirect()->route('external-sales.index')->with('success', 'Manual product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $sale = ExternalSale::findOrFail($id);
        // Optionally delete the related external purchase
        $purchase = $sale->purchase;
        $sale->delete();
        if ($purchase) {
            $purchase->delete();
        }
        return redirect()->route('external-sales.index')->with('success', 'Manual sale deleted successfully.');
    }
}
