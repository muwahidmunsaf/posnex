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
        Schema::table('inventory_sales', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->foreign('sale_id')->references('id')->on('sales'); // no cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_sales', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }
}; 