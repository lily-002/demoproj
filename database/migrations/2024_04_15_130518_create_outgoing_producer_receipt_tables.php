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
        Schema::create('producer_receipt_outgoings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_tax_number');
            $table->timestamp('producer_receipt_date');
            $table->string('mm_no');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('ettn');
            $table->string('gib_post_box_email');
            $table->string('mail_delivery_status')->nullable();
            $table->string('portal_status')->default('reload');
            $table->string('connector_status')->default('unread');
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

        Schema::create('producer_receipt_archives', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_tax_number');
            $table->timestamp('producer_receipt_date');
            $table->string('producer_receipt_no');
            $table->string('ettn');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('gib_post_box_email');
            $table->string('portal_status')->default('reload');
            $table->string('connector_status')->default('unread');
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

        Schema::create('producer_receipt_cancellations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_tax_number');
            $table->timestamp('producer_receipt_date');
            $table->string('producer_receipt_no');
            $table->string('ettn');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('gib_post_box_email');
            $table->string('mail_delivery_status')->nullable();
            $table->string('portal_status')->default('reload');
            $table->string('connector_status')->default('unread');
            $table->timestamp('cancellation_time')->nullable();
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

        Schema::create('producer_receipt_calls', function (Blueprint $table) {
            $table->id();
            $table->string('sender_company');
            $table->string('sender_company_vkn');
            $table->string('sender_company_mailbox');
            $table->string('customer_name');
            $table->string('customer_tax_number');
            $table->timestamp('mm_tarihi');
            $table->string('mm_no');
            $table->string('ettn');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('Update/waiting Accept');
            $table->string('gib_post_box_email');
            $table->string('portal_status')->default('unread');
            $table->string('connector_status')->default('unread');
            $table->string('cancell_status')->nullable();
            $table->boolean('is_archive')->default(false);
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
        Schema::dropIfExists('producer_receipt_outgoings');
        Schema::dropIfExists('producer_receipt_archives');
        Schema::dropIfExists('producer_receipt_cancellations');
        Schema::dropIfExists('producer_receipt_calls');
    }
};
