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
        Schema::create('einvoice_item_increases_decreases', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['increase', 'decrease']);
            $table->double('rate', 10, 2);
            $table->double('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('einvoice_item_increases_decreases');
    }
};
