<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'employee') {
            abort(403, 'Unauthorized');
        }
        $companyId = Auth::user()->company_id;
        $expenses = Expense::where('company_id', $companyId)->latest()->get();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'purpose' => 'required|string|max:255',
            'details' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'paidBy' => 'required|string|max:255',
            'paymentWay' => 'required|string|in:cash,card,online',
        ]);

        Expense::create([
            'purpose' => $request->purpose,
            'details' => $request->details,
            'amount' => $request->amount,
            'paidBy' => $request->paidBy,
            'paymentWay' => $request->paymentWay,
            'company_id' => Auth::user()->company_id,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }
}
