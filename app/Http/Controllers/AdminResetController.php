<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class AdminResetController extends Controller
{
    // Show the reset data form
    public function showResetForm()
    {
        $modules = [
            'suppliers' => 'Suppliers',
            'customers' => 'Customers',
            'distributors' => 'Distributors',
            'shopkeepers' => 'Shopkeepers',
            'sales' => 'Sales',
            'purchases' => 'Purchases',
            'inventory' => 'Inventory',
            'expenses' => 'Expenses',
            'payments' => 'Payments',
            'salary_payments' => 'Salary Payments',
            'distributor_payments' => 'Distributor Payments',
            'shopkeeper_transactions' => 'Shopkeeper Transactions',
            'external_purchases' => 'External Purchases',
            'external_sales' => 'External Sales',
            'activity_logs' => 'Activity Logs',
            'returns' => 'Returns',
        ];
        return view('admin.reset_data', compact('modules'));
    }

    // Handle the reset action
    public function resetData(Request $request)
    {
        $selected = $request->input('modules', []);
        $allTables = [
            'suppliers' => 'suppliers',
            'customers' => 'customers',
            'distributors' => 'distributors',
            'shopkeepers' => 'shopkeepers',
            'sales' => 'sales',
            'purchases' => 'purchases',
            'inventory' => 'inventory',
            'expenses' => 'expenses',
            'payments' => 'payments',
            'salary_payments' => 'salary_payments',
            'distributor_payments' => 'distributor_payments',
            'shopkeeper_transactions' => 'shopkeeper_transactions',
            'external_purchases' => 'external_purchases',
            'external_sales' => 'external_sales',
            'activity_logs' => 'activity_logs',
            'returns' => 'return_transactions',
        ];
        try {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            if (in_array('all', $selected)) {
                foreach ($allTables as $table) {
                    \DB::table($table)->truncate();
                }
            } else {
                foreach ($selected as $module) {
                    if (isset($allTables[$module])) {
                        \DB::table($allTables[$module])->truncate();
                    }
                }
            }
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return redirect()->back()->with('success', 'Selected data has been reset.');
        } catch (\Exception $e) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return redirect()->back()->with('error', 'Error resetting data: ' . $e->getMessage());
        }
    }
} 