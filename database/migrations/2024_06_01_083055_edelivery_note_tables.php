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
        //Submission types
          Schema::create('edelivery_note_submission_type', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
          });

          //Despatch type
          Schema::create('edelivery_note_despatch_type', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
          });

          //Invoice Scenario
          Schema::create('edelivery_note_invoice_scenario', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
          });

        
         

          //MASTER TABLE
          Schema::create('edelivery_note_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("company_id")->constrained("companies");

            $table->string("invoice_uuid")->unique();
            $table->foreignId("submission_type_id")->constrained("edelivery_note_submission_type");
            $table->timestamp("despatch_date")->nullable();
            $table->string("despatch_id")->nullable();
            $table->foreignId("despatch_type_id")->constrained("edelivery_note_despatch_type");
            $table->foreignId("invoice_scenario_id")->constrained("edelivery_note_invoice_scenario");
            $table->foreignId("currency_unit_id")->constrained("currencies");
            $table->string("carrier_title")->nullable();
            $table->string("carrier_tin")->nullable();
            $table->string("vehicle_plate_number")->nullable();
            $table->decimal("total_amount",10,2)->nullable();
            $table->string("wild_card1")->nullable();
            //Reciever Inofrmation
            $table->string("receiver_name")->nullable();
            $table->string("receiver_tax_number")->nullable();
            $table->string("receiver_gib_postacute")->nullable();
            $table->string("receiver_tax_office")->nullable();
            $table->string("receiver_country")->nullable();
            $table->string("receiver_city")->nullable();
            $table->string("receiver_destrict")->nullable();
            $table->longText("receiver_address")->nullable();
            $table->string("receiver_mobile_number")->nullable();
            //Real Buyer Information
            $table->string("real_buyer")->nullable();
            $table->string("buyer_tax_number")->nullable();
            $table->string("buyer_tax_admin")->nullable();
            $table->string("buyer_tax_office")->nullable();
            $table->string("buyer_country")->nullable();
            $table->string("buyer_city")->nullable();
            $table->string("buyer_destrict")->nullable();
            $table->longText("buyer_address")->nullable();
            //Real Seller Information
            $table->string("real_seller")->nullable();
            $table->string("seller_tax_number")->nullable();
            $table->string("seller_tax_admin")->nullable();
            $table->string("seller_tax_office")->nullable();
            $table->string("seller_country")->nullable();
            $table->string("seller_city")->nullable();
            $table->string("seller_destrict")->nullable();
            $table->longText("seller_address")->nullable();
            //Order Information
            $table->string("order_number")->nullable();
            $table->string("order_date")->nullable();
            $table->string("shipment_time")->nullable();
            //Billing Information
            $table->string("additional_document_id")->nullable();
            //2nd Reciever Information
            $table->string("second_receiver_country")->nullable();
            $table->string("second_receiver_ill")->nullable();
            $table->string("second_receiver_postal_code")->nullable();
            $table->string("second_receiver_district")->nullable();
            $table->longText("second_receiver_address")->nullable();
            // Remainings
            $table->longText("notes")->nullable();

            $table->timestamps();
          });

            Schema::create('edelivery_note_products', function (Blueprint $table) {
            $table->id();
            $table->string("product_service")->nullable();
            $table->decimal("quantity_one",10,5);
            $table->foreignId("unit_id_one")->constrained("measurement_units");
            $table->decimal("quantity_two",10,5);
            $table->foreignId("unit_id_two")->constrained("measurement_units");
            $table->decimal("price",10,2)->nullable();
            $table->decimal("product_amount",10,2)->nullable();
            $table->foreignId("edelivery_note_id")->constrained("edelivery_note_table")->onDelete("cascade");
            $table->foreignId("product_category_id")->nullable()->constrained("product_categories");
            $table->foreignId("product_subcategory_id")->nullable()->constrained("product_subcategories")->nullable();
            $table->timestamps();
          });

           Schema::create('edelivery_note_driver_info', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("surname")->nullable();
            $table->string("tckn")->nullable();
            $table->foreignId("edelivery_note_id")->constrained("edelivery_note_table")->onDelete("cascade");
            $table->timestamps();
          });
          Schema::create('edelivery_note_trailer_info', function (Blueprint $table) {
            $table->id();
            $table->string("plate_number")->nullable();
            $table->foreignId("edelivery_note_id")->constrained("edelivery_note_table")->onDelete("cascade");
            $table->timestamps();
          });
          Schema::create('edelivery_note_invoice_attachments', function (Blueprint $table) {
            $table->id();
            $table->string("file_url")->nullable();
            $table->foreignId("edelivery_note_id")->constrained("edelivery_note_table")->onDelete("cascade");
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
