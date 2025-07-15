<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateBusinessData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:business-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all business data tables (except users, settings, migrations, etc.)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'sales',
            'external_sales',
            'external_purchases',
            'purchases',
            'purchase_items',
            'inventory',
            'inventory_sales',
            'customers',
            'suppliers',
            'expenses',
            'distributors',
            'distributor_payments',
            'distributor_products',
            'shopkeepers',
            'shopkeeper_transactions',
            'salary_payments',
            'payments',
            'activity_logs',
            'return_transactions',
            'supplier_payments',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Business data truncated successfully!');
    }
} 