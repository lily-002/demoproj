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
        Schema::create('invoice_received_tables', function (Blueprint $table) {
            $table->id();
            // $table->foreignId("gib_invoice_type_id")->constrained();
            $table->string("customer_name");
            $table->string("add_payment");
            $table->decimal("amount_paid");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_received_tables');
    }
};
