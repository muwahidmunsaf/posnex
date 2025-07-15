<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('currency_code')->nullable()->after('company_id');
            $table->decimal('exchange_rate_to_pkr', 16, 8)->nullable()->after('currency_code');
            $table->decimal('pkr_amount', 12, 2)->nullable()->after('exchange_rate_to_pkr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
        });
    }
}; 