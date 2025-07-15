<?php

namespace App\Http\Controllers;

use App\Models\DistributorPayment;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributorPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $distributor_id = $request->get('distributor_id');
        $query = DistributorPayment::with('distributor');
        
        if ($distributor_id) {
            $query->where('distributor_id', $distributor_id);
        }
        
        $payments = $query->latest()->paginate(15);
        $distributors = Distributor::all();
        
        return view('distributor_payments.index', compact('payments', 'distributors', 'distributor_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $distributor_id = $request->get('distributor_id');
        $distributors = Distributor::all();
        return view('distributor_payments.create', compact('distributors', 'distributor_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $data = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:payment,commission,adjustment',
            'description' => 'nullable|string',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'reference_no' => 'nullable|string|max:255',
        ]);

        DistributorPayment::create($data);
        
        return redirect()->route('distributor-payments.index')
            ->with('success', 'Commission payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DistributorPayment $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        return view('distributor_payments.show', compact('distributorPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistributorPayment $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $distributors = Distributor::all();
        return view('distributor_payments.edit', compact('distributorPayment', 'distributors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DistributorPayment $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $data = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:payment,commission,adjustment',
            'description' => 'nullable|string',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'reference_no' => 'nullable|string|max:255',
        ]);
        $distributorPayment->update($data);
        return redirect()->route('distributor-payments.index')
            ->with('success', 'Commission payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistributorPayment $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        
        $distributorPayment->delete();
        return redirect()->route('distributor-payments.index')
            ->with('success', 'Commission payment deleted successfully.');
    }
}
