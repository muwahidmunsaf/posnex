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
            'returns' => 'return_transactions', // fixed table name
            'notes' => 'notes',
        ];
        try {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            // Truncate in dependency order: child tables first
            $truncateOrder = [
                'purchase_items',
                'purchases',
                'inventory_sales',
                'sales',
                'shopkeeper_transactions',
                'shopkeepers',
                'distributor_payments',
                'distributors',
                'external_purchases',
                'external_sales',
                'salary_payments',
                'employees',
                'payments',
                'customers',
                'suppliers',
                'expenses',
                'activity_logs',
                'return_transactions', // fixed table name
                'inventory',
                'notes',
            ];
            $selectedTables = [];
            if (in_array('all', $selected)) {
                $selectedTables = $truncateOrder;
            } else {
                // Only include selected tables, but in the correct order
                foreach ($truncateOrder as $table) {
                    foreach ($allTables as $key => $tbl) {
                        if (in_array($key, $selected) && $tbl === $table) {
                            $selectedTables[] = $table;
                        }
                    }
                }
            }
            foreach ($selectedTables as $table) {
                \DB::table($table)->truncate();
            }
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return redirect()->back()->with('success', 'Selected data has been reset.');
        } catch (\Exception $e) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return redirect()->back()->with('error', 'Error resetting data: ' . $e->getMessage());
        }
    }
} 