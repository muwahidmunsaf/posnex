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
        $user = Auth::user();
        $company = $user->company;
        $paymentMethod = $request->payment_method;

        $request->validate([
            'item_name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'purchase_amount' => 'required|numeric|min:0',
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
            'item_name' => $request->item_name,
            'details' => $request->details,
            'purchase_amount' => $request->purchase_amount,
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

        return view('external_sales.after-sale', ['saleId' => $sale->id]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
