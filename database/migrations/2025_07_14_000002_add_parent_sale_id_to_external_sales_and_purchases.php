<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('external_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_sale_id')->nullable()->after('company_id');
            $table->foreign('parent_sale_id')->references('id')->on('sales')->onDelete('set null');
        });
        Schema::table('external_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_sale_id')->nullable()->after('company_id');
            $table->foreign('parent_sale_id')->references('id')->on('sales')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::table('external_sales', function (Blueprint $table) {
            $table->dropForeign(['parent_sale_id']);
            $table->dropColumn('parent_sale_id');
        });
        Schema::table('external_purchases', function (Blueprint $table) {
            $table->dropForeign(['parent_sale_id']);
            $table->dropColumn('parent_sale_id');
        });
    }
}; 