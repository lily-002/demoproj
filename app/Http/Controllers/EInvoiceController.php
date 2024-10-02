<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EInvoice;
use App\Http\Requests\CreateEInvoiceRequest;

class EInvoiceController extends Controller
{
   
    // /** 
    //  * Get all einvoice for a company
    //  * @OA\Get(
    //  *     path="/user/einvoice/{id}",
    //  * summary="Get all einvoice for a company",
    //  *    tags={"EInvoice"},
    //  *    description="Get all einvoice for a company",
    //  *   operationId="einvoiceList",
    //  *  @OA\Parameter(
    //  *        name="id",
    //  *       in="path",
    //  *      required=true,
    //  *     @OA\Schema(
    //  *           type="integer"
    //  *      )
    //  *  ),
    //  * @OA\Response(
    //  *   response=200,
    //  *  description="success",
    //  * @OA\JsonContent(
    //  *  @OA\Property(
    //  * property="success",
    //  * type="boolean"
    //  * ),
    //  * @OA\Property(
    //  * property="message",
    //  * type="string"
    //  * ),
    //  * ),
    //  * ),
    //  * @OA\Response(
    //  *  response=400,
    //  * description="error",
    //  * @OA\JsonContent(
    //  * @OA\Property(
    //  * property="message",
    //  * type="string"
    //  * ),
    //  * ),
    //  * ),
    //  * ) 
    //  */
    public function list($id)
    {
        // Get the authenticated user
        $user = auth()->user();
        try {
            // Get the company associated with the user
            $company = $user->companies()->find($id);

            if (!$company) {
                // Company not found
                return response()->json([
                    'message' => 'You can\'t get EInvoice. please try again later',
                ], 400);
            }

            // Get all invoices for the company
            $einvoice = $company->einvoice;

            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $einvoice,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "You can't get EInvoice. please try again later " . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Create einvoice
    
     * @param CreateEInvoiceRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     */

     public function create(CreateEInvoiceRequest $request, $id)
     {
        // Invoice Item table
        // $table->string("invoice_uuid")->unique();
        //     $table->string("invoice_date");
        //     $table->string("invoice_date_time");
        //     $table->string("invoice_id");
        //     $table->string("exchange_rate")->nullable();
        //     $table->string("wildcard")->nullable();
        //     $table->string("invoice_tapdk_number")->nullable();
        //     $table->date("charge_start_date")->nullable();
        //     $table->string("charge_start_date_time")->nullable();
        //     $table->date("charge_end_date")->nullable();
        //     $table->string("charge_end_date_time")->nullable();
        //     $table->string("plate_number")->nullable();
        //     $table->string("vehicle_idenfitication_number")->nullable();
        //     $table->string("esu_rapor_id")->nullable();
        //     $table->date("esu_rapor_date")->nullable();
        //     $table->string("esu_rapor_date_time")->nullable();
        //     $table->string("receiver");
        //     $table->string("receiver_tax_number");
        //     $table->string("receiver_gib_postbox");
        //     $table->string("receiver_tapdk_no")->nullable();
        //     $table->string("receiver_tax_office")->nullable();
        //     $table->string("receiver_country");
        //     $table->string("receiver_city")->nullable();
        //     $table->string("receiver_county")->nullable();
        //     $table->longText("receiver_address")->nullable();
        //     $table->string("receiver_telephone")->nullable();
        //     $table->string("receiver_email")->nullable();
        //     $table->string("receiver_web")->nullable();
        //     $table->string("payment_date")->nullable();
        //     $table->string("payment_method")->nullable();
        //     $table->string("payment_channel_code")->nullable();
        //     $table->string("payee_financial_account")->nullable();
        //     $table->string("order_number")->nullable();
        //     $table->string("order_date")->nullable();
        //     $table->string("dispatch_number")->nullable();  
        //     $table->date("despatch_date")->nullable();
        //     $table->string("mode_code")->nullable();
        //     $table->string("tr_id_number")->nullable();
        //     $table->string("declarer_name")->nullable();
        //     $table->string("export_buyer_name")->nullable();
        //     $table->string("export_buyer_surname")->nullable();
        //     $table->string("export_buyer_nationality")->nullable();
        //     $table->string("export_buyer_passport_number")->nullable();
        //     $table->date("export_buyer_passport_date")->nullable();
        //     $table->longText("notes")->nullable();
        //     $table->decimal("total_products_services", 10, 2);
        //     $table->decimal("total_discounts", 10, 2);
        //     $table->decimal("total_increase", 10, 2);
        //     $table->decimal("total_0015_vat", 10, 2);
        //     $table->decimal("total_taxes", 10, 2);
        //     $table->decimal("bottom_total_discount_rate", 10, 2);
        //     $table->unsignedBigInteger('invoice_send_type_id')->nullable();
        //     $table->foreign('invoice_send_type_id')->references('id')->on('invoice_send_type');
        //     $table->unsignedBigInteger('invoice_type_id')->nullable();
        //     $table->foreign('invoice_type_id')->references('id')->on('invoice_type');
        //     $table->unsignedBigInteger('invoice_scenario_id')->nullable();
        //     $table->foreign('invoice_scenario_id')->references('id')->on('invoice_scenario');
        //     $table->unsignedBigInteger('invoice_currency_id')->nullable();
        //     $table->foreign('invoice_currency_id')->references('id')->on('currencies');
        //     $table->unsignedBigInteger("company_id");
        //     $table->foreign("company_id")->references("id")->on("companies")->cascadeOnDelete()->cascadeOnUpdate();

        //Invoice Item table
        // $table->string("product");
        //     $table->double("quantity", 10, 2)->nullable();
        //     $table->double("price", 10, 2)->nullable();
        //     $table->double("0015_vat_rate", 10, 2)->nullable();
        //     $table->double("0015_vat_amount", 10, 2)->nullable();
        //     $table->double("taxline_total", 10, 2)->nullable();
        //     $table->double("payable_total", 10, 2)->nullable();
        //     $table->unsignedBigInteger("unit_id");
        //     $table->foreign("unit_id")->references("id")->on("units")->cascadeOnDelete()->cascadeOnUpdate();
        //     $table->unsignedBigInteger("increases_decreases_id");
        //     $table->foreign("increases_decreases_id")->references("id")->on("einvoice_item_increases_decreases")->cascadeOnDelete()->cascadeOnUpdate();
        //     $table->unsignedBigInteger("einvoice_id");
        //     $table->foreign("einvoice_id")->references("id")->on("einvoice")->cascadeOnDelete()->cascadeOnUpdate();

        //Invoice Attachment table
        // Schema::create('invoice_attachment', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('url');
        //     $table->unsignedBigInteger('invoice_id');
        //     $table->foreign('invoice_id')->references('id')->on('einvoice')->onDelete('cascade');
        //     $table->timestamps();
        // });

        //Invoice decreases increases table
        //  Schema::create('einvoice_item_increases_decreases', function (Blueprint $table) {
        //     $table->id();
        //     $table->enum('type', ['increase', 'decrease']);
        //     $table->double('rate', 10, 2);
        //     $table->double('amount', 10, 2);
        //     $table->timestamps();
        // });

        // Get the authenticated user
        $user = auth()->user();
        try {
            // Get the company associated with the user
            $company = $user->companies()->find($id);

            if (!$company) {
                // Company not found
                return response()->json([
                    'message' => 'You can\'t create EInvoice. please try again later',
                ], 400);
            }

            $InvoiceValidator = $request->validated();

            if ($InvoiceValidator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $InvoiceValidator->errors(),
                ], 400);
            }

            // Create the invoice
            $einvoice = new EInvoice();

            //list of products
            $products = $request->products;
            

            $einvoice->invoice_uuid = $request->invoice_uuid;
            $einvoice->invoice_date = $request->invoice_date;
            $einvoice->invoice_date_time = $request->invoice_date_time;
            $einvoice->invoice_id = $request->invoice_id;
            $einvoice->exchange_rate = $request->exchange_rate;
            $einvoice->wildcard = $request->wildcard;
            $einvoice->invoice_tapdk_number = $request->invoice_tapdk_number;
            $einvoice->charge_start_date = $request->charge_start_date;
            $einvoice->charge_start_date_time = $request->charge_start_date_time;
            $einvoice->charge_end_date = $request->charge_end_date;
            $einvoice->charge_end_date_time = $request->charge_end_date_time;
            $einvoice->plate_number = $request->plate_number;
            $einvoice->vehicle_idenfitication_number = $request->vehicle_idenfitication_number;
            $einvoice->esu_rapor_id = $request->esu_rapor_id;
            $einvoice->esu_rapor_date = $request->esu_rapor_date;
            $einvoice->esu_rapor_date_time = $request->esu_rapor_date_time;
            $einvoice->receiver = $request->receiver;
            $einvoice->receiver_tax_number = $request->receiver_tax_number;
            $einvoice->receiver_gib_postbox = $request->receiver_gib_postbox;
            $einvoice->receiver_tapdk_no = $request->receiver_tapdk_no;
            $einvoice->receiver_tax_office = $request->receiver_tax_office;
            $einvoice->receiver_country = $request->receiver_country;
            $einvoice->receiver_city = $request->receiver_city;
            $einvoice->receiver_address = $request->receiver_address;
            $einvoice->receiver_telephone = $request->receiver_telephone;
            $einvoice->receiver_email = $request->receiver_email;
            $einvoice->receiver_web = $request->receiver_web;   
            $einvoice->payment_date = $request->payment_date;
            $einvoice->payment_method = $request->payment_method;
            $einvoice->payment_channel_code = $request->payment_channel_code;
            $einvoice->payee_financial_account = $request->payee_financial_account;
            $einvoice->order_number = $request->order_number;
            $einvoice->order_date = $request->order_date;
            $einvoice->dispatch_number = $request->dispatch_number;
            $einvoice->despatch_date = $request->despatch_date;
            $einvoice->mode_code = $request->mode_code;
            $einvoice->tr_id_number = $request->tr_id_number;
            $einvoice->declarer_name = $request->declarer_name;
            $einvoice->export_buyer_name = $request->export_buyer_name;
            $einvoice->export_buyer_surname = $request->export_buyer_surname;
            $einvoice->export_buyer_nationality = $request->export_buyer_nationality;
            $einvoice->export_buyer_passport_number = $request->export_buyer_passport_number;
            $einvoice->export_buyer_passport_date = $request->export_buyer_passport_date;
            $einvoice->notes = $request->notes;
            $einvoice->total_products_services = $request->total_products_services;
            $einvoice->total_discounts = $request->total_discounts;
            $einvoice->total_increase = $request->total_increase;
            $einvoice->total_0015_vat = $request->total_0015_vat;
            $einvoice->total_taxes = $request->total_taxes;
            $einvoice->bottom_total_discount_rate = $request->bottom_total_discount_rate;
            $einvoice->invoice_send_type_id = $request->invoice_send_type_id;
            $einvoice->invoice_type_id = $request->invoice_type_id;
            $einvoice->invoice_scenario_id = $request->invoice_scenario_id;
            $einvoice->invoice_currency_id = $request->invoice_currency_id;
            $einvoice->company_id = $company->id;
            $einvoice->save();
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "You can't create EInvoice. please try again later " . $e->getMessage()
            ], 500);
        }

            



















     }
    
    //Create ubl e-invoice xml
    public function createUblXml($einvoice_id)
    {
        // Get the authenticated user
        $user = auth()->user();
        try {
            //find the einvoice
            $einvoice = EInvoice::with('einvoiceItem')->find($einvoice_id);
            // Get the company associated with the user
            $company = $user->companies()->find($einvoice->company_id);

            if (!$company) {
                // Company not found
                return response()->json([
                    'message' => 'Invoice not exists.',
                ], 403);
            }

            //now create the xml
            $xml = new \SimpleXMLElement('<Invoice></Invoice>');
            $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
            $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
            $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
            $xml->addAttribute('xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
            $xml->addAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
            $xml->addAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
            $xml->addAttribute('xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
            $xml->addAttribute('xmlns:sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');
            $xml->addAttribute('xmlns:udt', 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2');
            $xml->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
            $xml->addAttribute('xsi:schemaLocation', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 ../xsd/maindoc/UBL-Invoice-2.1.xsd');
            $xml->addAttribute('xmlns:xades', 'http://uri.etsi.org/01903/v1.3.2#');
            $xml->addAttribute('xmlns:xades141', 'http://uri.etsi.org/01903/v1.4.1#');
            $xml->addChild('ext:UBLExtensions');
            $xml->addChild('cbc:UBLVersionID', '2.1');
            $xml->addChild('cbc:CustomizationID', '2.0');
            $xml->addChild('cbc:ID', $einvoice->id);
            $xml->addChild('cbc:IssueDate', date('Y-m-d', strtotime($einvoice->created_at)));
            $xml->addChild('cbc:InvoiceTypeCode', '01');
            $xml->addChild('cbc:DocumentCurrencyCode', 'IDR');
            $xml->addChild('cac:Signature');
            $xml->addChild('cac:AccountingSupplierParty');
            $xml->addChild('cbc:CustomerAssignedAccountID', $company->id);
            $xml->addChild('cbc:AdditionalAccountID', '6');
            $xml->addChild('cac:Party');
            $xml->addChild('cac:PartyIdentification');
            $xml->addChild('cbc:ID', $company->id);
            $xml->addChild('cac:PartyName');
            $xml->addChild('cbc:Name', $company->company_name);
            $xml->addChild('cac:PartyLegalEntity');
            $xml->addChild('cbc:RegistrationName', $company->company_name);
            $xml->addChild('cac:RegistrationAddress');
            $xml->addChild('cbc:AddressTypeCode', '0000');
            $xml->addChild('cbc:CityName', $company->city);
            $xml->addChild('cbc:PostalZone', $company->postal_code);
            $xml->addChild('cbc:CountrySubentity', $company->province);
            $xml->addChild('cac:TaxScheme');
            $xml->addChild('cbc:ID', '01');
            $xml->addChild('cbc:Name', 'PPN');
            $xml->addChild('cbc:TaxTypeCode', 'VAT');
            $xml->addChild('cac:PartyTaxScheme');
            $xml->addChild('cbc:RegistrationName', $company->company_name);
            $xml->addChild('cac:TaxScheme');
            $xml->addChild('cbc:ID', '01');
            $xml->addChild('cbc:Name', 'PPN');
            $xml->addChild('cbc:TaxTypeCode', 'VAT');
            $xml->addChild('cac:PartyLegalEntity');
            $xml->addChild('cbc:RegistrationName', $company->company_name);
            $xml->addChild('cac:Contact');
            $xml->addChild('cbc:ElectronicMail', $company->email);
            $xml->addChild('cac:AccountingCustomerParty');
            $xml->addChild('cbc:CustomerAssignedAccountID', $einvoice->id);
            $xml->addChild('cbc:AdditionalAccountID', '6');
            $xml->addChild('cac:Party');
            $xml->addChild('cac:PartyIdentification');
            $xml->addChild('cbc:ID', $einvoice->id);
            $xml->addChild('cac:PartyName');
            $xml->addChild('cbc:Name', $einvoice->receiver_name);
            $xml->addChild('cac:PartyLegalEntity');
            $xml->addChild('cbc:RegistrationName', $einvoice->receiver_name);
            $xml->addChild('cac:RegistrationAddress');
            $xml->addChild('cbc:AddressTypeCode', '0000');
            $xml->addChild('cbc:CityName', $einvoice->receiver_address);
            $xml->addChild('cbc:PostalZone', $einvoice->receiver_phone);
            $xml->addChild('cbc:CountrySubentity', $einvoice->receiver_email);
            $xml->addChild('cac:TaxScheme');
            $xml->addChild('cbc:ID', '01');
            $xml->addChild('cbc:Name', 'PPN');
            $xml->addChild('cbc:TaxTypeCode', 'VAT');
            $xml->addChild('cac:PartyTaxScheme');
            $xml->addChild('cbc:RegistrationName', $einvoice->receiver_name);
            $xml->addChild('cac:TaxScheme');
            $xml->addChild('cbc:ID', '01');
            $xml->addChild('cbc:Name', 'PPN');
            $xml->addChild('cbc:TaxTypeCode', 'VAT');
            $xml->addChild('cac:PartyLegalEntity');
            $xml->addChild('cbc:RegistrationName', $einvoice->receiver_name);
            $xml->addChild('cac:Contact');
            $xml->addChild('cbc:ElectronicMail', $einvoice->receiver_email);
            $xml->addChild('cac:PaymentMeans');
            $xml->addChild('cbc:PaymentMeansCode', '1');
            $xml->addChild('cbc:PaymentDueDate', date('Y-m-d', strtotime($einvoice->created_at)));
            $xml->addChild('cbc:PaymentChannelCode', '380');
            $xml->addChild('cac:PayeeFinancialAccount');
            $xml->addChild('cbc:ID', '380');
            $xml->addChild('cbc:PaymentID', '380');
            $xml->addChild('cac:PaymentTerms');
            $xml->addChild('cbc:Note', '380');
            $xml->addChild('cac:TaxTotal');
            $xml->addChild('cbc:TaxAmount', $einvoice->invoice_total);
            $xml->addChild('cac:TaxSubtotal');
            $xml->addChild('cbc:TaxableAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:TaxAmount', $einvoice->invoice_total);
            $xml->addChild('cac:TaxCategory');
            $xml->addChild('cbc:Percent', '10');
            $xml->addChild('cac:TaxScheme');
            $xml->addChild('cbc:ID', '01');
            $xml->addChild('cbc:Name', 'PPN');
            $xml->addChild('cbc:TaxTypeCode', 'VAT');
            $xml->addChild('cac:LegalMonetaryTotal');
            $xml->addChild('cbc:LineExtensionAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:TaxExclusiveAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:TaxInclusiveAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:PayableAmount', $einvoice->invoice_total);
            $xml->addChild('cac:InvoiceLine');
            $xml->addChild('cbc:ID', '1');
            $xml->addChild('cbc:InvoicedQuantity', '1');
            $xml->addChild('cbc:LineExtensionAmount', $einvoice->invoice_total);
            $xml->addChild('cac:PricingReference');
            $xml->addChild('cac:AlternativeConditionPrice');
            $xml->addChild('cbc:PriceAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:PriceTypeCode', '01');
            $xml->addChild('cac:TaxTotal');
            $xml->addChild('cbc:TaxAmount', $einvoice->invoice_total);
            $xml->addChild('cac:TaxSubtotal');
            $xml->addChild('cbc:TaxableAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:TaxAmount', $einvoice->invoice_total);
            $xml->addChild('cac:TaxCategory');
            $xml->addChild('cbc:Percent', '10');
            $xml->addChild('cac:TaxScheme');
            $xml->addChild('cbc:ID', '01');
            $xml->addChild('cbc:Name', 'PPN');
            $xml->addChild('cbc:TaxTypeCode', 'VAT');
            $xml->addChild('cac:Item');
            $xml->addChild('cbc:Description', '380');
            $xml->addChild('cac:SellersItemIdentification');
            $xml->addChild('cbc:ID', '380');
            $xml->addChild('cac:Price');
            $xml->addChild('cbc:PriceAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:BaseQuantity', '1');
            $xml->addChild('cac:TaxTotal');
            $xml->addChild('cbc:TaxAmount', $einvoice->invoice_total);
            $xml->addChild('cac:TaxSubtotal');
            $xml->addChild('cbc:TaxableAmount', $einvoice->invoice_total);
            $xml->addChild('cbc:TaxAmount', $einvoice->invoice_total);
            $xml->addChild('cac:TaxCategory');
            $xml->addChild('cbc:Percent', '10');
            $xml->addChild('cac:TaxScheme');
            $xml->addChild('cbc:ID', '01');
            $xml->addChild('cbc:Name', 'PPN');


            $xml->asXML('einvoice.xml');

            return response()->json([
                'message' => 'success',
                'data' => $xml,
            ]);
        
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "You can't create EInvoice. please try again later " . $e->getMessage()
            ], 500);
        }
    }
}