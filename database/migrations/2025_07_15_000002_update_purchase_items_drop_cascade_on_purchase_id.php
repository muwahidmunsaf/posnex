<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropForeign(['purchase_id']);
            $table->foreign('purchase_id')->references('id')->on('purchases'); // no cascade
        });
    }
    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropForeign(['purchase_id']);
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        });
    }
}; 