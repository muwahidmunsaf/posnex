<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanySettingsController extends Controller
{
    public function edit()
    {
        $company = Auth::user()->company;
        return view('company.settings', compact('company'));
    }

    public function update(Request $request)
    {
        $company = Auth::user()->company;

        $request->validate([
            'name' => 'required|string|max:255',
            'cell_no' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'taxCash' => 'nullable|numeric',
            'taxCard' => 'nullable|numeric',
            'taxOnline' => 'nullable|numeric',
            'logo' => 'nullable|image|max:2048',
        ]);

        // Map camelCase inputs to database snake_case columns
        $data = [
            'name' => $request->name,
            'cell_no' => $request->cell_no,
            'email' => $request->email,
            'tax_cash' => $request->taxCash,
            'tax_card' => $request->taxCard,
            'tax_online' => $request->taxOnline,
            'website' => $request->website,
            'address' => $request->address,
        ];
        if ($request->hasFile('logo')) {
            if ($company->logo && \Storage::disk('public')->exists($company->logo)) {
                \Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('company_logos', 'public');
        }
        $company->update($data);

        return back()->with('success', 'Company settings updated.');
    }
}
