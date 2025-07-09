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
            'action' => 'Recorded Payment',
            'details' => 'Customer ID: ' . $validated['customer_id'] . ', Amount: ' . $validated['amount_paid'] . ', Note: ' . ($validated['note'] ?? ''),
        ]);

        return Redirect::back()->with('success', 'Payment recorded successfully.');
    }
} 