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
        Schema::create('invoice_decrease_increase', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['decrease', 'increase']);
            $table->integer('rate')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->foreignId('invoice_product_id')->constrained('invoice_products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
