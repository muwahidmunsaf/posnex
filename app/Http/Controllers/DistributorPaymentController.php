<?php

namespace App\Http\Controllers;

use App\Models\DistributorPayment;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;

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

        $payment = DistributorPayment::create($data);

        // If this is a commission payment, add to expenses
        if ($data['type'] === 'commission') {
            Expense::create([
                'purpose' => 'Distributor Commission',
                'details' => 'Commission paid to distributor ID: ' . $data['distributor_id'],
                'amount' => $data['amount'],
                'paidBy' => Auth::user()->name,
                'paymentWay' => 'cash', // or use a field if available
                'company_id' => Auth::user()->company_id,
            ]);
        }
        
        return redirect()->route('distributors.history', ['distributor' => $data['distributor_id']])
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
    public function update(Request $request, $distributor, $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $distributorPayment = \App\Models\DistributorPayment::findOrFail($distributorPayment);
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
        $distributorId = $distributorPayment->distributor_id ?? ($distributorPayment->distributor ? $distributorPayment->distributor->id : null);
        if ($distributorId) {
            return redirect()->route('distributors.history', ['distributor' => $distributorId])
                ->with('success', 'Commission payment updated successfully.');
        } else {
            return redirect()->route('distributors.index')
                ->with('error', 'Commission payment updated, but distributor not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($distributor, $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        $payment = \App\Models\DistributorPayment::findOrFail($distributorPayment);
        \Log::info('Destroy called for DistributorPayment', ['id' => $payment->id, 'distributor_id' => $payment->distributor_id]);
        $distributorId = $payment->distributor_id ?? ($payment->distributor ? $payment->distributor->id : null);
        $deleted = $payment->delete();
        \Log::info('Delete result', ['deleted' => $deleted]);
        if ($distributorId) {
            return redirect()->route('distributors.history', ['distributor' => $distributorId])
                ->with('success', 'Commission payment deleted successfully.');
        } else {
            return redirect()->route('distributors.index')
                ->with('error', 'Commission payment deleted, but distributor not found.');
        }
    }
}
