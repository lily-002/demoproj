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
        Schema::create('incoming_delivery_notes_incoming', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_tax_number');
            $table->string('gib_dispatch_type');
            $table->string('supplier_code')->nullable();
            $table->timestamp('dispatch_date');
            $table->string('dispatch_id');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('dispatch_uuid');
            $table->string('wild_card1')->nullable();
            $table->string('erp_reference')->nullable();
            $table->string('order_number')->nullable();
            $table->string('activity_envelope')->nullable();
            $table->string('package_info');
            $table->timestamp('recieved_date')->nullable();;
            $table->timestamp('response_date')->nullable();;
            $table->string('mail_delivery_status')->nullable();
            $table->string('portal_status')->nullable();
            $table->string('connector_status')->nullable();
            $table->string('last_update_user');
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_delivery_notes_incoming');
    }
};
