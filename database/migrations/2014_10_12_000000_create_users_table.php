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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('mobile')->nullable();
            $table->string('username')->unique();
            $table->string('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->boolean("notification_einvoice")->default(false);
            $table->boolean("notification_edispatch")->default(false);
            $table->string('luca_username')->unique()->nullable();
            $table->string('luca_member_number')->nullable();
            $table->string('luca_password')->nullable();
            $table->boolean("export_only")->default(false);
            $table->boolean("earchive")->default(false);
            $table->boolean("einvoice_only")->default(false);
            $table->boolean("ssi_only")->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
