<?php

namespace App\Http\Controllers;

use App\Models\SalaryPayment;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SalaryPayment::with('employee')->orderByDesc('date');
        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('date', date('m', strtotime($request->month)))
                  ->whereYear('date', date('Y', strtotime($request->month)));
        }
        // Search by employee name
        if ($request->filled('search')) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        $salaries = $query->get();
        $selectedMonth = $request->month;
        $search = $request->search;
        return view('salaries.index', compact('salaries', 'selectedMonth', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('salaries.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);
        $salary = SalaryPayment::create($request->only('employee_id', 'amount', 'date'));
        // Create expense record
        Expense::create([
            'purpose' => 'Salary Payment',
            'details' => 'Salary paid to employee ID: ' . $salary->employee_id,
            'amount' => $salary->amount,
            'paidBy' => Auth::user()->name,
            'paymentWay' => 'cash',
            'company_id' => Auth::user()->company_id,
        ]);
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->role,
            'action' => 'Created Salary Payment',
            'details' => 'Employee ID: ' . $salary->employee_id . ', Amount: ' . $salary->amount,
        ]);
        return redirect()->route('salaries.index')->with('success', 'Salary payment added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salary = SalaryPayment::with('employee')->findOrFail($id);
        return view('salaries.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $salary = SalaryPayment::findOrFail($id);
        $employees = Employee::all();
        return view('salaries.edit', compact('salary', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);
        $salary = SalaryPayment::findOrFail($id);
        $salary->update($request->only('employee_id', 'amount', 'date'));
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->role,
            'action' => 'Updated Salary Payment',
            'details' => 'Employee ID: ' . $salary->employee_id . ', Amount: ' . $salary->amount,
        ]);
        return redirect()->route('salaries.index')->with('success', 'Salary payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $salary = SalaryPayment::findOrFail($id);
        // Delete related expense
        Expense::where('purpose', 'Salary Payment')
            ->where('details', 'Salary paid to employee ID: ' . $salary->employee_id)
            ->where('amount', $salary->amount)
            ->delete();
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->role,
            'action' => 'Deleted Salary Payment',
            'details' => 'Employee ID: ' . $salary->employee_id . ', Amount: ' . $salary->amount,
        ]);
        $salary->delete();
        return redirect()->route('salaries.index')->with('success', 'Salary payment deleted successfully.');
    }

    public function bulkForm()
    {
        $employees = Employee::with('salaryPayments')->get();
        return view('salaries.bulk', compact('employees'));
    }

    public function bulkPay(Request $request)
    {
        $request->validate([
            'employee_ids' => 'required|array',
            'date' => 'required|date',
        ]);
        $employees = Employee::whereIn('id', $request->employee_ids)->get();
        foreach ($employees as $employee) {
            $salary = SalaryPayment::create([
                'employee_id' => $employee->id,
                'amount' => $employee->salary,
                'date' => $request->date,
            ]);
            // Create expense record
            Expense::create([
                'purpose' => 'Salary Payment',
                'details' => 'Salary paid to employee ID: ' . $employee->id,
                'amount' => $employee->salary,
                'paidBy' => Auth::user()->name,
                'paymentWay' => 'cash',
                'company_id' => Auth::user()->company_id,
            ]);
        }
        return redirect()->route('salaries.index')->with('success', 'Salaries paid successfully.');
    }
}
