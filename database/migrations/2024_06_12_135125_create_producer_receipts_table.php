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
        Schema::create('producer_receipts', function (Blueprint $table) {
            $table->id();
            // mm information
            $table->string('producer_uuid');
            $table->timestamp('producer_date');
            $table->string('producer_name');
            $table->foreignId("unit_id")
                  ->constrained("measurement_units");
            $table->decimal('total_amount', 10, 2);
            $table->string('title');
            // Receiver information
            $table->string('receiver_name');
            $table->string('receiver_tax_number');
            $table->string('receiver_tax_office')->nullable();
            $table->boolean('sms_notification_for_earchive')->default(false);
            $table->boolean('add_to_address_book')->default(false);
            // Buyer address information
            $table->string('buyer_country');
            $table->string('buyer_city')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('buyer_mobile_number')->nullable();
            $table->string('buyer_web_address')->nullable();
            $table->string('buyer_address');
            // Totals
            $table->decimal('total_product_services', 10, 2);
            $table->decimal('total_0003_stoppage', 10, 2);
            $table->decimal('total_taxes', 10, 2);
            $table->decimal('total_payable', 10, 2);
            $table->longText('notes')->nullable();

            $table->foreignId("company_id")->constrained("companies")->null;
            $table->foreignId("user_id")->constrained("users");
            $table->timestamps();
        });

        // Product and services
        Schema::create('producer_receipt_products', function (Blueprint $table) {
            $table->id();
            $table->string("fee_reason")->nullable();
            $table->decimal("quantity1", 10, 5);
            $table->decimal("quantity2", 10, 5);
            $table->foreignId("unit_id1")
                  ->constrained("measurement_units");
            $table->foreignId("unit_id2")
                  ->constrained("measurement_units");
            $table->decimal("price", 10 ,2)->nullable();
            $table->decimal("gross_amount", 10 ,2)->nullable();
            $table->decimal("rate", 10 ,2)->nullable();
            $table->decimal("amount", 10 ,2)->nullable();
            $table->decimal("tax_line_total", 10 ,2)->nullable();
            $table->decimal("payable_line", 10 ,2)->nullable();
            $table->foreignId("product_category_id")->nullable()->constrained("product_categories");
            $table->foreignId("product_subcategory_id")->nullable()->constrained("product_subcategories");
            $table->foreignId("producer_receipt_id")
                  ->constrained("producer_receipts")
                  ->onDelete("cascade")
                  ->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producer_receipts');
        Schema::dropIfExists('producer_receipt_products');
    }
};
