<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('company.index', compact('companies'));
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wholesale,retail,both',
            'cell_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'ntn' => 'nullable|string|max:30',
            'tel_no' => 'nullable|string|max:20',
            'taxCash' => 'nullable|numeric|min:0',
            'taxCard' => 'nullable|numeric|min:0',
            'taxOnline' => 'nullable|numeric|min:0',
        ]);

        Company::create($request->only([
            'name', 'type', 'cell_no', 'email', 'ntn', 'tel_no',
            'taxCash', 'taxCard', 'taxOnline'
        ]));

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Company $company)
    {
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wholesale,retail,both',
            'cell_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'ntn' => 'nullable|string|max:30',
            'tel_no' => 'nullable|string|max:20',
            'taxCash' => 'nullable|numeric|min:0',
            'taxCard' => 'nullable|numeric|min:0',
            'taxOnline' => 'nullable|numeric|min:0',
        ]);

        $company->update($request->only([
            'name', 'type', 'cell_no', 'email', 'ntn', 'tel_no',
            'taxCash', 'taxCard', 'taxOnline'
        ]));

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
