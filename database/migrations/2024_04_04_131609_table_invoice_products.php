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
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_service')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit_measurement')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('taxable_amount', 15, 2)->nullable();
            $table->decimal('zero_zero_one_five_vat_rate', 5, 2)->nullable();
            $table->decimal('zero_zero_one_five_vat_amount', 15, 2)->nullable();
            $table->decimal('taxline_total', 5, 2)->nullable();
            $table->decimal('payabl_line_total', 15, 2)->nullable();
            $table->foreignId('invoice_id')->constrained("invoices")->onDelete('cascade');
            $table->foreignId("product_category_id")->nullable()->constrained("product_categories");
            $table->foreignId("product_subcategory_id")->nullable()->constrained("product_subcategories");

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
