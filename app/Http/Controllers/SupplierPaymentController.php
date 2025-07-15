<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierPayment;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierPaymentController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorizeAdmin();
        $payments = SupplierPayment::all();
        return view('supplier_payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdmin();
        $suppliers = Supplier::all();
        return view('supplier_payments.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);
        $data = $request->all();
        SupplierPayment::create($data);
        return redirect()->route('supplier-payments.index')->with('success', 'Supplier payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->authorizeAdmin();
        $payment = SupplierPayment::findOrFail($id);
        return view('supplier_payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorizeAdmin();
        $payment = SupplierPayment::findOrFail($id);
        $suppliers = Supplier::all();
        return view('supplier_payments.edit', compact('payment', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);
        $payment = SupplierPayment::findOrFail($id);
        $payment->update($request->all());
        return redirect()->route('supplier-payments.index')->with('success', 'Supplier payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();
        $payment = SupplierPayment::findOrFail($id);
        $payment->delete();
        return redirect()->route('supplier-payments.index')->with('success', 'Supplier payment deleted successfully.');
    }
}
