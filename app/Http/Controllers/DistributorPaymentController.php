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

        $expenseId = null;
        // If this is a commission payment, add to expenses and link
        if ($data['type'] === 'commission') {
            $expense = Expense::create([
                'purpose' => 'Distributor Commission',
                'details' => 'Commission paid to distributor ID: ' . $data['distributor_id'],
                'amount' => $data['amount'],
                'paidBy' => Auth::user()->name,
                'paymentWay' => 'cash', // or use a field if available
                'company_id' => Auth::user()->company_id,
                'created_at' => $data['payment_date'],
            ]);
            $expenseId = $expense->id;
        }
        $payment = DistributorPayment::create(array_merge($data, ['expense_id' => $expenseId]));
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
    public function update(Request $request, Distributor $distributor, DistributorPayment $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        if ($distributorPayment->distributor_id != $distributor->id) {
            abort(404);
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
        // If this is a commission payment and has an expense, update it
        if ($distributorPayment->type === 'commission' && $distributorPayment->expense_id) {
            $expense = Expense::find($distributorPayment->expense_id);
            if ($expense) {
                $expense->update([
                    'amount' => $data['amount'],
                    'details' => 'Commission paid to distributor ID: ' . $data['distributor_id'],
                    'purpose' => 'Distributor Commission',
                    'paidBy' => Auth::user()->name,
                    'paymentWay' => 'cash',
                    'company_id' => Auth::user()->company_id,
                    'created_at' => $data['payment_date'],
                ]);
            }
        }
        $distributorPayment->update($data);
        return redirect()->route('distributors.history', ['distributor' => $distributor->id])
            ->with('success', 'Commission payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor, DistributorPayment $distributorPayment)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403);
        }
        if ($distributorPayment->distributor_id != $distributor->id) {
            abort(404);
        }
        // If this is a commission payment and has an expense, delete it
        if ($distributorPayment->type === 'commission' && $distributorPayment->expense_id) {
            $expense = Expense::find($distributorPayment->expense_id);
            if ($expense) {
                $expense->delete();
            }
        }
        $distributorPayment->delete();
        return redirect()->route('distributors.history', ['distributor' => $distributor->id])
            ->with('success', 'Commission payment deleted successfully.');
    }
}
