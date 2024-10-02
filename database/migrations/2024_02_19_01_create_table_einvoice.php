<?php

use App\Enums\Currency;
use App\Enums\InvoiceScenario;
use App\Enums\InvoiceSendType;
use App\Enums\InvoiceType;
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
        Schema::create('einvoice', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_uuid")->unique();
            $table->string("invoice_date");
            $table->string("invoice_date_time");
            $table->string("invoice_id");
            $table->string("exchange_rate")->nullable();
            $table->string("wildcard")->nullable();
            $table->string("invoice_tapdk_number")->nullable();
            $table->date("charge_start_date")->nullable();
            $table->string("charge_start_date_time")->nullable();
            $table->date("charge_end_date")->nullable();
            $table->string("charge_end_date_time")->nullable();
            $table->string("plate_number")->nullable();
            $table->string("vehicle_idenfitication_number")->nullable();
            $table->string("esu_rapor_id")->nullable();
            $table->date("esu_rapor_date")->nullable();
            $table->string("esu_rapor_date_time")->nullable();
            $table->string("receiver");
            $table->string("receiver_tax_number");
            $table->string("receiver_gib_postbox");
            $table->string("receiver_tapdk_no")->nullable();
            $table->string("receiver_tax_office")->nullable();
            $table->string("receiver_country");
            $table->string("receiver_city")->nullable();
            $table->string("receiver_county")->nullable();
            $table->longText("receiver_address")->nullable();
            $table->string("receiver_telephone")->nullable();
            $table->string("receiver_email")->nullable();
            $table->string("receiver_web")->nullable();
            $table->string("payment_date")->nullable();
            $table->string("payment_method")->nullable();
            $table->string("payment_channel_code")->nullable();
            $table->string("payee_financial_account")->nullable();
            $table->string("order_number")->nullable();
            $table->string("order_date")->nullable();
            $table->string("dispatch_number")->nullable();  
            $table->date("despatch_date")->nullable();
            $table->string("mode_code")->nullable();
            $table->string("tr_id_number")->nullable();
            $table->string("declarer_name")->nullable();
            $table->string("export_buyer_name")->nullable();
            $table->string("export_buyer_surname")->nullable();
            $table->string("export_buyer_nationality")->nullable();
            $table->string("export_buyer_passport_number")->nullable();
            $table->date("export_buyer_passport_date")->nullable();
            $table->longText("notes")->nullable();
            $table->decimal("total_products_services", 10, 2);
            $table->decimal("total_discounts", 10, 2);
            $table->decimal("total_increase", 10, 2);
            $table->decimal("total_0015_vat", 10, 2);
            $table->decimal("total_taxes", 10, 2);
            $table->decimal("bottom_total_discount_rate", 10, 2);
            $table->unsignedBigInteger('invoice_send_type_id')->nullable();
            $table->foreign('invoice_send_type_id')->references('id')->on('invoice_send_type');
            $table->unsignedBigInteger('invoice_type_id')->nullable();
            $table->foreign('invoice_type_id')->references('id')->on('invoice_type');
            $table->unsignedBigInteger('invoice_scenario_id')->nullable();
            $table->foreign('invoice_scenario_id')->references('id')->on('invoice_scenario');
            $table->unsignedBigInteger('invoice_currency_id')->nullable();
            $table->foreign('invoice_currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger("company_id");
            $table->foreign("company_id")->references("id")->on("companies")->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('einvoice');
    }
};
