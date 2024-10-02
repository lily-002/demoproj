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
         Schema::create('address_book', function (Blueprint $table) {
            $table->id();
            // Supplier Information
            $table->string("supplier_name");
            $table->string("supplier_code");
            $table->string("tax_office")->nullable();
            $table->string("tax_number");

            //Payment Information
            $table->foreignId("payment_method_id")->nullable()->constrained("payment_methods");
            $table->string("payment_channel")->nullable();
            $table->string("payment_account_number")->nullable();

            //Communication Information
            $table->string("country")->nullable();
            $table->string("city")->nullable();
            $table->string("county")->nullable();
            $table->string("post_code")->nullable();
            $table->string("phone_number")->nullable();
            $table->longText("address")->nullable();
            $table->longText("mobile_phone_notification")->nullable();
            $table->boolean("outgoing_einvoice_sms_notification")->default(false);
            $table->boolean("sent_sms_earchive_invoice")->default(false);
            $table->boolean("sent_email_earchive_invoice")->default(false);
            $table->string("email")->nullable();
            $table->string("web_url")->nullable();
            $table->timestamps();

            //E-Invoice E-Archive Information
            $table->string("gib_registration_date")->nullable();
            $table->string("gib_receiver_alias")->nullable();

            //E-Delivery Note Information
            $table->string("gib_mailbox_label")->nullable();

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
