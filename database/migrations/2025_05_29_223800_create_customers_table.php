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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['retail', 'wholesale', 'both']);
            $table->string('cel_no');
            $table->string('email')->nullable();
            $table->string('cnic')->nullable(); // Format: 00000-0000000-0
            $table->text('address')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraint assuming companies table exists
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
