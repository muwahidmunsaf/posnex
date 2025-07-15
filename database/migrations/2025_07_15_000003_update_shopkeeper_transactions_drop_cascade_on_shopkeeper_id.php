<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shopkeeper_transactions', function (Blueprint $table) {
            $table->dropForeign(['shopkeeper_id']);
            $table->foreign('shopkeeper_id')->references('id')->on('shopkeepers'); // no cascade
        });
    }
    public function down(): void
    {
        Schema::table('shopkeeper_transactions', function (Blueprint $table) {
            $table->dropForeign(['shopkeeper_id']);
            $table->foreign('shopkeeper_id')->references('id')->on('shopkeepers')->onDelete('cascade');
        });
    }
}; 