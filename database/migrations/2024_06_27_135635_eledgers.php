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
        Schema::create('eledger_transaction_types', function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create('eledger_categories', function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create('eledger_tax_infos', function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->timestamps();
        });


        // Schema::create('eledger_payment_methods', function(Blueprint $table){
        //     $table->id();
        //     $table->string("name");
        //     $table->timestamps();
        // });

        Schema::create('eledger_statuses', function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->timestamps();
        });
        
        
        Schema::create('eledgers', function (Blueprint $table) {
            $table->id();
            $table->string("account_name");
            $table->foreignId("transaction_type_id")->constrained("eledger_transaction_types");
            $table->decimal('amount', 10, 2);
            $table->foreignId("currency_id")->constrained("currencies");
            $table->string("transaction_date");
            $table->longText("description");
            $table->string("reference_number")->nullable();
            $table->foreignId("category_id")->constrained("eledger_categories");
            $table->string("attachment_url")->nullable();
            $table->foreignId("tax_info_id")->nullable()->constrained("eledger_tax_infos");
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->foreignId("payment_method_id")->nullable()->constrained("payment_methods");
            $table->string("payer_name")->nullable();
            $table->string("payer_id_number")->nullable();
            $table->foreignId("status_id")->constrained("eledger_statuses");
            $table->string("created_by");
            $table->string("updated_by")->nullable();
            $table->string("file")->nullable();
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("company_id")->constrained("companies")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eledgers');
        Schema::dropIfExists('eledger_status');
        Schema::dropIfExists('eledger_payment_methods');
        Schema::dropIfExists('eledger_tax_info');
        Schema::dropIfExists('eledger_categories');
        Schema::dropIfExists('eledger_transaction_types');
    }
};
