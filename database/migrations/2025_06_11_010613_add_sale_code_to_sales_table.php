<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('sales', function (Blueprint $table) {
        if (!Schema::hasColumn('sales', 'sale_code')) {
        $table->string('sale_code')->nullable()->after('id'); // Step 1: Add nullable column
        }
    });

    // Optional: If you already have data and want to backfill unique codes
    // You can write a DB::table(...)->update(...) here
    // But usually you'd do it in a seeder or manually

    // Only add unique index if it doesn't exist
    if (!\Illuminate\Support\Facades\Schema::hasColumn('sales', 'sale_code')) {
    Schema::table('sales', function (Blueprint $table) {
        $table->unique('sale_code'); // Step 2: Add unique index only after data is ready
    });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
};
