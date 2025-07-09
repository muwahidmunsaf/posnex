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
        Schema::create('external_sales', function (Blueprint $table) {
            $table->id();
            $table->string('saleE_id')->unique(); // e.g. N001-00001
            $table->string('purchaseE_id');
            $table->decimal('sale_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'card', 'online']);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('created_by');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_sales');
    }
};
