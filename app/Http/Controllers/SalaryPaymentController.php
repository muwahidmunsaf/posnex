<?php

namespace App\Http\Controllers;

use App\Models\SalaryPayment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SalaryPaymentController extends Controller
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

    public function index()
    {
        $this->authorizeAdmin();
        $payments = SalaryPayment::all();
        return view('salary_payments.index', compact('payments'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $employees = Employee::all();
        return view('salary_payments.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        SalaryPayment::create($validated);
        
        return redirect()->route('salary-payments.index')->with('success', 'Salary payment created successfully');
    }

    public function show(string $id)
    {
        $this->authorizeAdmin();
        $payment = SalaryPayment::findOrFail($id);
        return view('salary_payments.show', compact('payment'));
    }

    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $payment = SalaryPayment::findOrFail($id);
        $employees = Employee::all();
        return view('salary_payments.edit', compact('payment', 'employees'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $payment = SalaryPayment::findOrFail($id);
        $payment->update($validated);
        
        return redirect()->route('salary-payments.index')->with('success', 'Salary payment updated successfully');
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $payment = SalaryPayment::findOrFail($id);
        $payment->delete();
        
        return redirect()->route('salary-payments.index')->with('success', 'Salary payment deleted successfully');
    }
}
