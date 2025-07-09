<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Expense;
use App\Models\ActivityLog;

class EmployeeController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $employees = Employee::where('company_id', $companyId)->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        $validated['company_id'] = Auth::user()->company_id;
        $employee = Employee::create($validated);
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->role,
            'action' => 'Created Employee',
            'details' => 'Employee: ' . $employee->name,
        ]);
        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        $employee->update($validated);
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->role,
            'action' => 'Updated Employee',
            'details' => 'Employee: ' . $employee->name,
        ]);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $name = $employee->name;
        $employee->delete();
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->role,
            'action' => 'Deleted Employee',
            'details' => 'Employee: ' . $name,
        ]);
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function show(Employee $employee)
    {
        $salaryPayments = $employee->salaryPayments()->orderBy('date', 'desc')->get();
        return view('employees.show', compact('employee', 'salaryPayments'));
    }

    public function paySalariesForm()
    {
        $companyId = Auth::user()->company_id;
        $employees = Employee::where('company_id', $companyId)->with('salaryPayments')->get();
        return view('employees.pay_salaries', compact('employees'));
    }

    public function paySalariesProcess(Request $request)
    {
        $request->validate([
            'employee_ids' => 'required|array',
            'date' => 'required|date',
        ]);
        $companyId = Auth::user()->company_id;
        $userName = Auth::user()->name;
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        $employees = Employee::whereIn('id', $request->employee_ids)->where('company_id', $companyId)->get();
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
                'paidBy' => $userName,
                'paymentWay' => 'cash',
                'company_id' => $companyId,
            ]);
            // Log activity
            ActivityLog::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'user_role' => $userRole,
                'action' => 'Bulk Salary Payment',
                'details' => 'Employee ID: ' . $employee->id . ', Amount: ' . $employee->salary,
            ]);
        }
        return redirect()->route('employees.index')->with('success', 'Salaries paid successfully.');
    }
} 