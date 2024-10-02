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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("company_id")->constrained("companies");
            //Invoice Information
            $table->foreignId('send_type')->constrained('invoice_send_types');
            $table->string('invoice_uuid')->unique();
            $table->string('invoice_date');
            $table->string('invoice_time');
            $table->string('invoice_id');
            $table->foreignId('invoice_type')->constrained('invoice_types');
            $table->foreignId('invoice_scenario')->constrained('invoice_scenarios');
            $table->foreignId('invoice_currency')->constrained('currencies');
            $table->string('exchange_rate')->nullable();
            $table->string('wildcard_1')->nullable();
            $table->string('your_tapdk_number')->nullable();
            $table->string('charge_start_date')->nullable();
            $table->string('charge_start_time')->nullable();
            $table->string('charge_end_date')->nullable();
            $table->string('charge_end_time')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('vehicle_id')->nullable();
            $table->string('esu_report_id')->nullable();
            $table->string('esu_report_date')->nullable();
            $table->string('esu_report_time')->nullable();

            //Order Information
            $table->string('order_number')->nullable();
            $table->string('order_date')->nullable();
            //Dispatch Note Information
            $table->string('dispatch_number')->nullable();
            $table->string('dispatch_date')->nullable();
            $table->string('dispatch_time')->nullable();
            //Special Additional Information
            $table->string('mode_code')->nullable();
            $table->string('tr_id_number')->nullable();
            $table->string('name_declarer')->nullable();
            //Export Buyer Information
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_date')->nullable();

            //Receiver Information
            $table->string('receiver_name')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('gib_post_box')->nullable();
            $table->string('receiver_tapdk_number')->nullable();
            $table->string('tax_office')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_web')->nullable();
            $table->string('receiver_phone')->nullable();

            //Payment Information
            $table->string('payment_date')->nullable();
            $table->string('payment_means')->nullable();
            $table->string('payment_channel_code')->nullable();
            $table->string('payee_financial_account')->nullable();

            $table->integer('total_products')->nullable();
            $table->decimal('total_discount', 15, 2)->nullable();
            $table->decimal('total_increase', 15, 2)->nullable();
            $table->decimal('zero_zero_one_five_vat', 15, 2)->nullable();
            $table->decimal('total_taxes', 15, 2)->nullable();
            $table->decimal('bottom_total_discount_rate', 15, 2)->nullable();

            $table->string("notes")->nullable();
            $table->string("attachment")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
