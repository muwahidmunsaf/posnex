<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->decimal('tax_cash', 8, 2)->nullable()->default(0);
            $table->decimal('tax_card', 8, 2)->nullable()->default(0);
            $table->decimal('tax_online', 8, 2)->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['tax_cash', 'tax_card', 'tax_online']);
        });
    }
}; 