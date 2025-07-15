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
        Schema::table('distributor_payments', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->unsignedBigInteger('distributor_id')->nullable()->change();
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributor_payments', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->unsignedBigInteger('distributor_id')->nullable(false)->change();
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
        });
    }
};
