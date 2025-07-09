<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'employee') {
            abort(403, 'Unauthorized');
        }
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'cell_no' => 'required|string|max:20',
            'contact_person' => 'required|string|max:255',
        ]);

        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'cell_no' => $request->cell_no,
            'tel_no' => $request->tel_no,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => Auth::user()->company_id,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully.');
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
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'cell_no' => 'required|string|max:20',
            'contact_person' => 'required|string|max:255',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier deleted successfully.');
    }
}
