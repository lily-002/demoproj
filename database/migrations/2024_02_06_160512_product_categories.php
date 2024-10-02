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
          Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("vat",10,5)->nullable();
            $table->timestamps();
          });

           Schema::create('product_subcategories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("product_category_id")->constrained("product_categories")->onDelete("cascade");
            $table->decimal("vat",10,5)->nullable();
            $table->timestamps();
          });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('product_categories');
    }
};
