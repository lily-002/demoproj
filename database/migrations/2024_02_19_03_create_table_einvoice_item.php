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
        Schema::create('einvoice_item', function (Blueprint $table) {
            $table->id();
            $table->string("product");
            $table->double("quantity", 10, 2)->nullable();
            $table->double("price", 10, 2)->nullable();
            $table->double("0015_vat_rate", 10, 2)->nullable();
            $table->double("0015_vat_amount", 10, 2)->nullable();
            $table->double("taxline_total", 10, 2)->nullable();
            $table->double("payable_total", 10, 2)->nullable();
            $table->unsignedBigInteger("unit_id");
            $table->foreign("unit_id")->references("id")->on("units")->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger("increases_decreases_id");
            $table->foreign("increases_decreases_id")->references("id")->on("einvoice_item_increases_decreases")->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger("einvoice_id");
            $table->foreign("einvoice_id")->references("id")->on("einvoice")->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('einvoice_item');
    }
};
