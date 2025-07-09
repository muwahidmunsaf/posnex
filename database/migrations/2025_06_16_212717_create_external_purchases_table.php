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
        Schema::create('external_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchaseE_id')->unique(); // e.g. N001-00001
            $table->string('item_name');
            $table->text('details')->nullable();
            $table->decimal('purchase_amount', 10, 2);
            $table->string('purchase_source')->nullable();
            $table->string('created_by');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_purchases');
    }
};
