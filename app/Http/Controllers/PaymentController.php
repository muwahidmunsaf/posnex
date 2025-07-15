<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount_paid' => 'required|numeric|min:0',
            'amount_due' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        Payment::create([
            'customer_id' => $validated['customer_id'],
            'amount_paid' => $validated['amount_paid'],
            'amount_due' => $validated['amount_due'] ?? 0,
            'date' => now()->toDateString(),
            'note' => $validated['note'] ?? null,
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_role' => auth()->user()->role,
            'action' => 'Created Payment',
            'details' => 'Customer ID: ' . $validated['customer_id'] . ', Amount: ' . $validated['amount_paid'] . ', Note: ' . ($validated['note'] ?? ''),
        ]);

        return Redirect::back()->with('success', 'Payment recorded successfully.');
    }

    public function update(Request $request, $id)
    {
        $payment = \App\Models\Payment::findOrFail($id);
        $validated = $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'amount_due' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);
        $payment->amount_paid = $validated['amount_paid'];
        $payment->amount_due = $validated['amount_due'] ?? 0;
        $payment->note = $validated['note'] ?? null;
        $payment->save();
        return redirect()->back()->with('success', 'Payment updated successfully.');
    }

    public function print($id)
    {
        $payment = \App\Models\Payment::findOrFail($id);
        $customer = $payment->customer;
        return view('payments.receipt', compact('payment', 'customer'));
    }

    public function destroy($id)
    {
        $payment = \App\Models\Payment::findOrFail($id);
        $payment->delete();
        return redirect()->back()->with('success', 'Payment deleted successfully.');
    }
} 