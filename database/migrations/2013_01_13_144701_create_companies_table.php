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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('tax_number')->nullable();
            $table->string('tax_office')->nullable();
            $table->string('mersis_number')->nullable();
            $table->string('business_registry_number')->nullable();
            $table->string('operating_center')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->longText('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();
            $table->date('gib_registration_data')->nullable();
            $table->string('gib_sender_alias')->nullable();
            $table->string('gib_receiver_alias')->nullable();
            $table->string('e-signature_method')->nullable();
            $table->date('date_of_last_update')->nullable();
            $table->string('last_update_user')->nullable();
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }

   
};
