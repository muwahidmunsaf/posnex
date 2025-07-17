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
        Schema::create('cloud_backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Admin who connected
            $table->string('provider')->default('google');
            $table->string('email')->nullable(); // Google account email
            $table->string('name')->nullable(); // Google account name
            $table->string('refresh_token');
            $table->string('folder_id')->nullable();
            $table->string('frequency')->default('daily'); // daily, weekly, monthly
            $table->string('time')->default('02:00'); // 24h format, e.g. 02:00
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloud_backups');
    }
};
