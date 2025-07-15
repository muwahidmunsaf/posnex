<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Only run for MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE inventory_sales MODIFY sale_type ENUM('retail','wholesale','distributor')");
        }
        // For SQLite and others, do nothing (or handle as needed)
    }
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE inventory_sales MODIFY sale_type ENUM('retail','wholesale')");
        }
    }
};
