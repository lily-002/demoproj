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
        Schema::create('outgoing_delivery_note_call', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("company_id")->constrained("companies")->onDelete("cascade");
            /**  Delivery Note Information */
            $table->string('sender_company');
            $table->string('sender_company_vkn');
            $table->string('sender_company_mailbox');
            $table->string('customer_name');
            $table->string('customer_tax_number');
            $table->string('gib_dispatch_type')->nullable();
            $table->string('gib_dispatch_send_type')->nullable();
            $table->string('supplier_code')->nullable();
            $table->date('dispatch_date');
            $table->string('dispatch_id');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('dispatch_uuid')->nullable();
            $table->string('gib_post_box_email')->nullable();
            $table->string('wild_card1')->nullable();
            $table->string('erp_reference')->nullable();
            $table->string('order_number')->nullable();
            $table->string('package_info')->nullable();
            $table->dateTime('send_date')->nullable();
            $table->dateTime('received_date')->nullable();
            $table->dateTime('response_date')->nullable();
            $table->string('mail_delivery_status')->nullable();
            $table->string('portal_status')->nullable();
            $table->string('connector_status')->nullable();
            $table->string('cancel_status')->nullable();
            $table->boolean('is_archive')->nullable();
            $table->string('last_update_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_delivery_note_call');
    }
};
