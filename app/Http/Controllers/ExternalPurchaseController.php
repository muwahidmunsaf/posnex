<?php

namespace App\Http\Controllers;

use App\Models\ExternalPurchase;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExternalPurchaseController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $externalPurchases = ExternalPurchase::with('company')->paginate(20);
        return view('external_purchases.index', compact('externalPurchases'));
    }

    public function create()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $companies = Company::all();
        return view('external_purchases.create', compact('companies'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $validated = $request->validate([
            'purchaseE_id' => 'nullable|string|unique:external_purchases',
            'item_name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'purchase_amount' => 'required|numeric|min:0',
            'purchase_source' => 'nullable|string|max:255',
            'created_by' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // Auto-set missing required fields
        $validated['company_id'] = $validated['company_id'] ?? Auth::user()->company_id;
        $validated['created_by'] = $validated['created_by'] ?? Auth::user()->name;
        $validated['purchaseE_id'] = $validated['purchaseE_id'] ?? 'N001-' . str_pad(ExternalPurchase::count() + 1, 5, '0', STR_PAD_LEFT);

        ExternalPurchase::create($validated);

        return redirect()->route('external-purchases.index')->with('success', 'External purchase created successfully.');
    }

    public function show(ExternalPurchase $externalPurchase)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        return view('external_purchases.show', compact('externalPurchase'));
    }

    public function edit(ExternalPurchase $externalPurchase)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $companies = Company::all();
        return view('external_purchases.edit', compact('externalPurchase', 'companies'));
    }

    public function update(Request $request, ExternalPurchase $externalPurchase)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $validated = $request->validate([
            'purchaseE_id' => 'nullable|string|unique:external_purchases,purchaseE_id,' . $externalPurchase->id,
            'item_name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'purchase_amount' => 'required|numeric|min:0',
            'purchase_source' => 'nullable|string|max:255',
            'created_by' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // Auto-set missing required fields
        $validated['company_id'] = $validated['company_id'] ?? Auth::user()->company_id;
        $validated['created_by'] = $validated['created_by'] ?? Auth::user()->name;

        $externalPurchase->update($validated);

        return redirect()->route('external-purchases.index')->with('success', 'External purchase updated successfully.');
    }

    public function destroy(ExternalPurchase $externalPurchase)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $externalPurchase->delete();

        return redirect()->route('external-purchases.index')->with('success', 'External purchase deleted successfully.');
    }
} 