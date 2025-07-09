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
        Schema::table('companies', function (Blueprint $table) {
            $table->decimal('taxCash', 5, 2)->default(0)->after('name');
            $table->decimal('taxCard', 5, 2)->default(0)->after('taxCash');
            $table->decimal('taxOnline', 5, 2)->default(0)->after('taxCard');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['taxCash', 'taxCard', 'taxOnline']);
        });
    }
};
