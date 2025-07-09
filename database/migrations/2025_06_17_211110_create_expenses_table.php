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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('purpose');               // Short title or category of the expense
            $table->text('details')->nullable();     // Optional additional description
            $table->decimal('amount', 10, 2);        // Expense amount
            $table->string('paidBy');                // Person or department that paid
            $table->string('paymentWay');            // E.g., cash, card, bank transfer
            $table->foreignId('company_id')->constrained()->onDelete('cascade');            // Foreign key to companies table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
