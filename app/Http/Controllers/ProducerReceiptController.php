<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProducerReceipt;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProducerReceiptRequest;
use App\Http\Requests\UpdateProducerReceiptRequest;
use App\Models\ProducerReceiptProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Sabre\Xml\Service;

class ProducerReceiptController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/producer-receipts",
     *     summary="Get list of producer receipts with pagination",
     *     tags={"Producer Receipts"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit the number of results",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producer receipts retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function index($limit = 10)
    {
        $user = auth()->user();

        try {

            $receipts = ProducerReceipt::where('user_id', $user->id)
                ->with('unit', 'products','products.productCategory', 'products.productCategory.productSubCategory')
                ->paginate($limit);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipts retreived',
                'data' => $receipts
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    /**
     * @OA\Post(
     *     path="/user/producer-receipts",
     *     summary="Store a newly created receipt in storage",
     *     tags={"Producer Receipts"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Producer receipt data",
     *         @OA\JsonContent(
     *             required={"producer_date", "producer_name", "unit_id", "total_amount", "title", "receiver_name", "receiver_tax_number", "buyer_country", "buyer_address", "total_product_services", "total_0003_stoppage", "total_taxes", "total_payable", "products"},
     *             @OA\Property(property="producer_uuid", type="string", example="123456"),
     *             @OA\Property(property="producer_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="producer_name", type="string", example="Producer Name"),
     *             @OA\Property(property="unit_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="total_amount", type="number", format="float", example=100.00),
     *             @OA\Property(property="title", type="string", example="Title"),
     *             @OA\Property(property="receiver_name", type="string", example="Receiver Name"),
     *             @OA\Property(property="receiver_tax_number", type="string", example="Receiver Tax Number"),
     *             @OA\Property(property="receiver_tax_office", type="string", example="Receiver Tax Office"),
     *             @OA\Property(property="sms_notification_for_earchive", type="boolean", example="true"),
     *             @OA\Property(property="add_to_address_book", type="boolean", example="true"),
     *             @OA\Property(property="buyer_country", type="string", example="Buyer Country"),
     *             @OA\Property(property="buyer_city", type="string", example="Buyer City"),
     *             @OA\Property(property="buyer_email", type="string", example="buyer@example.com"),
     *             @OA\Property(property="buyer_mobile_number", type="string", example="1234567890"),
     *             @OA\Property(property="buyer_web_address", type="string", example="http://example.com"),
     *             @OA\Property(property="buyer_address", type="string", example="Buyer Address"),
     *             @OA\Property(property="total_product_services", type="number", format="float", example=100.00),
     *             @OA\Property(property="total_0003_stoppage", type="number", format="float", example=10.00),
     *             @OA\Property(property="total_taxes", type="number", format="float", example=15.00),
     *             @OA\Property(property="total_payable", type="number", format="float", example=125.00),
     *             @OA\Property(property="notes", type="string", example="Notes"),
     *             @OA\Property(property="company_id", type="string", example="Company ID is required for admin user only"),
     *             @OA\Property(
     *                 property="products", 
     *                 type="array",
     *                 @OA\Items(
     *                     required={"fee_reason", "quantity1", "quantity2", "unit_id1", "unit_id2", "price", "gross_amount", "rate", "amount", "tax_line_total", "payable_line"},
     *                     @OA\Property(property="fee_reason", type="string", example="Fee Reason"),
     *                     @OA\Property(property="quantity1", type="number", format="float", example=1.00),
     *                     @OA\Property(property="quantity2", type="number", format="float", example=1.00),
     *                     @OA\Property(property="unit_id1", type="integer", format="int64", example=1),
     *                     @OA\Property(property="unit_id2", type="integer", format="int64", example=1),
     *                     @OA\Property(property="price", type="number", format="float", example=10.00),
     *                     @OA\Property(property="gross_amount", type="number", format="float", example=10.00),
     *                     @OA\Property(property="rate", type="number", format="float", example=0.18),
     *                     @OA\Property(property="amount", type="number", format="float", example=1.80),
     *                     @OA\Property(property="tax_line_total", type="number", format="float", example=1.80),
     *                     @OA\Property(property="payable_line", type="number", format="float", example=11.80),
     *                     @OA\Property(property="product_category_id", type="string", example="3"),
     *                     @OA\Property(property="product_subcategory_id", type="string", example="1"),
     *                 )
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producer receipt created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function store(StoreProducerReceiptRequest $request)
    {
        $user = auth()->user();

        try{
            DB::beginTransaction();

            $data = $request->validated();

            $receipt = ProducerReceipt::create([
                'producer_uuid' => $data['producer_uuid'],
                'producer_date' => $data['producer_date'],
                'producer_name' => $data['producer_name'],
                'unit_id' => $data['unit_id'],
                'total_amount' => $data['total_amount'],
                'title' => $data['title'],
                'receiver_name' => $data['receiver_name'],
                'receiver_tax_number' => $data['receiver_tax_number'],
                'receiver_tax_office' => $data['receiver_tax_office'],
                'sms_notification_for_earchive' => $data['sms_notification_for_earchive'],
                'add_to_address_book' => $data['add_to_address_book'],
                'buyer_country' => $data['buyer_country'],
                'buyer_city' => $data['buyer_city'],
                'buyer_email' => $data['buyer_email'],
                'buyer_mobile_number' => $data['buyer_mobile_number'],
                'buyer_web_address' => $data['buyer_web_address'],
                'buyer_address' => $data['buyer_address'],
                'total_product_services' => $data['total_product_services'],
                'total_0003_stoppage' => $data['total_0003_stoppage'],
                'total_taxes' => $data['total_taxes'],
                'total_payable' => $data['total_payable'],
                'notes' => $data['notes'],
                'user_id' => $user->id,
                "company_id" => $user->hasRole('admin') ? $data['company_id'] : $user->company_id,
            ]);

            // create products
            if (isset($data['products']) && is_array($data['products'])) {
                $receipt->products()->createMany($data['products']);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt created',
                'data' => $receipt
            ], 201);

         }catch (\Exception $e) {
        
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     /**
     * @OA\Get(
     *     path="/user/producer-receipts/{id}",
     *     summary="Get a specific producer receipt",
     *     tags={"Producer Receipts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Producer receipt ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producer receipt retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $user = auth()->user();

        try {
            $receipt = ProducerReceipt::where('user_id', $user->id)
                ->with('unit', 'products','products.productCategory', 'products.productCategory.productSubCategory')
                ->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt retreived',
                'data' => $receipt
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Server error, try again',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/user/producer-receipts/{id}",
     *     summary="Update the specified receipt in storage",
     *     tags={"Producer Receipts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Producer receipt ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Producer receipt data",
     *         @OA\JsonContent(
     *             required={"producer_date", "producer_name", "unit_id", "total_amount", "title", "receiver_name", "receiver_tax_number", "buyer_country", "buyer_address", "total_product_services", "total_0003_stoppage", "total_taxes", "total_payable", "products"},
     *             @OA\Property(property="producer_uuid", type="string", example="123456"),
     *             @OA\Property(property="producer_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="producer_name", type="string", example="Producer Name"),
     *             @OA\Property(property="unit_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="total_amount", type="number", format="float", example=100.00),
     *             @OA\Property(property="title", type="string", example="Title"),
     *             @OA\Property(property="receiver_name", type="string", example="Receiver Name"),
     *             @OA\Property(property="receiver_tax_number", type="string", example="Receiver Tax Number"),
     *             @OA\Property(property="receiver_tax_office", type="string", example="Receiver Tax Office"),
     *             @OA\Property(property="sms_notification_for_earchive", type="boolean", example="true"),
     *             @OA\Property(property="add_to_address_book", type="boolean", example="true"),
     *             @OA\Property(property="buyer_country", type="string", example="Buyer Country"),
     *             @OA\Property(property="buyer_city", type="string", example="Buyer City"),
     *             @OA\Property(property="buyer_email", type="string", example="buyer@example.com"),
     *             @OA\Property(property="buyer_mobile_number", type="string", example="1234567890"),
     *             @OA\Property(property="buyer_web_address", type="string", example="http://example.com"),
     *             @OA\Property(property="buyer_address", type="string", example="Buyer Address"),
     *             @OA\Property(property="total_product_services", type="number", format="float", example=100.00),
     *             @OA\Property(property="total_0003_stoppage", type="number", format="float", example=10.00),
     *             @OA\Property(property="total_taxes", type="number", format="float", example=15.00),
     *             @OA\Property(property="total_payable", type="number", format="float", example=125.00),
     *             @OA\Property(property="notes", type="string", example="Notes"),
     *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *             @OA\Property(
     *                 property="products", 
     *                 type="array",
     *                 @OA\Items(
     *                     required={"id", "fee_reason", "quantity1", "quantity2", "unit_id1", "unit_id2", "price", "gross_amount", "rate", "amount", "tax_line_total", "payable_line"},
     *                     @OA\Property(property="id", type="integer", format="int64", example=1),
     *                     @OA\Property(property="fee_reason", type="string", example="Fee Reason"),
     *                     @OA\Property(property="quantity1", type="number", format="float", example=1.00),
     *                     @OA\Property(property="quantity2", type="number", format="float", example=1.00),
     *                     @OA\Property(property="unit_id1", type="integer", format="int64", example=1),
     *                     @OA\Property(property="unit_id2", type="integer", format="int64", example=1),
     *                     @OA\Property(property="price", type="number", format="float", example=10.00),
     *                     @OA\Property(property="gross_amount", type="number", format="float", example=10.00),
     *                     @OA\Property(property="rate", type="number", format="float", example=0.18),
     *                     @OA\Property(property="amount", type="number", format="float", example=1.80),
     *                     @OA\Property(property="tax_line_total", type="number", format="float", example=1.80),
     *                     @OA\Property(property="payable_line", type="number", format="float", example=11.80),
     *                     @OA\Property(property="product_category_id", type="string", example="3"),
     *                     @OA\Property(property="product_subcategory_id", type="string", example="1"),
     *                 )
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producer receipt updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function update(UpdateProducerReceiptRequest $request, $id)
    {
        $user = auth()->user();

        try{
            DB::beginTransaction();

            $data = $request->validated();

            $receipt = ProducerReceipt::where('user_id', $user->id)->findOrFail($id);

            $receipt->update([
                'producer_date' => $data['producer_date'],
                'producer_name' => $data['producer_name'],
                'unit_id' => $data['unit_id'],
                'total_amount' => $data['total_amount'],
                'title' => $data['title'],
                'receiver_name' => $data['receiver_name'],
                'receiver_tax_number' => $data['receiver_tax_number'],
                'receiver_tax_office' => $data['receiver_tax_office'],
                'sms_notification_for_earchive' => $data['sms_notification_for_earchive'],
                'add_to_address_book' => $data['add_to_address_book'],
                'buyer_country' => $data['buyer_country'],
                'buyer_city' => $data['buyer_city'],
                'buyer_email' => $data['buyer_email'],
                'buyer_mobile_number' => $data['buyer_mobile_number'],
                'buyer_web_address' => $data['buyer_web_address'],
                'buyer_address' => $data['buyer_address'],
                'total_product_services' => $data['total_product_services'],
                'total_0003_stoppage' => $data['total_0003_stoppage'],
                'total_taxes' => $data['total_taxes'],
                'total_payable' => $data['total_payable'],
                'notes' => $data['notes'],
                'user_id' => $user->id,
                "company_id" => $user->hasRole('admin') ? $data['company_id'] : $user->company_id,

            ]);

            // update products
            if (isset($data['products']) && is_array($data['products'])) {
                foreach ($data['products'] as $product) {
                    $product = ProducerReceiptProduct::findOrFail($product['id']);
                    if ($product) {
                        $product->update($product);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt updated',
                'data' => $receipt
            ], 200);

         }catch (\Exception $e) {
        
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/user/producer-receipts/{id}",
     *     summary="Remove the specified receipt from storage",
     *     tags={"Producer Receipts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Producer receipt ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producer receipt deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producer receipt not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $user = auth()->user();

        try {

            $receipt = ProducerReceipt::where('user_id', $user->id)->findOrFail($id);
            $receipt->delete();

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt deleted'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
               'status' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     /** generate ubl xml using ubl v2.1 
     * @OA\Get(
     *    path="/user/producer-receipts/ubl/{id}",
     *  tags={"Producer Receipts"},
     * summary="Generate UBL XML",
     * description="Generate UBL XML",
     * operationId="generateProducerReceiptUbl2.1",
     * @OA\Parameter(
     *   name="id",
     * in="path",
     * description="ID of the receipt",
     * required=true,
     * @OA\Schema(
     *  type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="UBL XML generated successfully!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example="false"),
     * @OA\Property(property="xml", type="string")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Receipt not found!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolien", example="false"),
     * @OA\Property(property="message", type="string", example="Receipt not found!")
     * )
     * )
     * )
     */
    public function generateUbl($receiptId)
    {
        $user = auth()->user();
        
        $receipt = ProducerReceipt::where('user_id', $user->id)
            ->with('company', 'unit', 'products')
            ->find($receiptId);
        
        if (!$receipt) {
            return response()->json([
                'status' => false,
                'message' => 'Receipt not found!'
            ], 404);
        }

        try {
            $producerDate = Carbon::parse($receipt->producer_date);

            $xmlService = new Service();
            $xmlService->namespaceMap = [
                'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2' => '',
                'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac',
                'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
            ];

            $receiptData = [
                'cbc:UBLVersionID' => '2.1',
                'cbc:CustomizationID' => 'TR1.2',
                'cbc:ProfileID' => 'TEMELFATURA',
                'cbc:ID' => $receipt->id,
                'cbc:CopyIndicator' => 'false',
                'cbc:UUID' => $receipt->producer_uuid,
                'cbc:IssueDate' => $producerDate->toDateString(),
                'cbc:IssueTime' => $producerDate->toTimeString(),
                'cbc:CreditNoteTypeCode'=>'PRODUCERRECEIPT',
                'cbc:DocumentCurrencyCode' => 'TRY',
                'cac:AccountingSupplierParty' => [
                    'cac:Party' => [
                        'cac:PartyIdentification' => [
                            'cbc:ID' => $receipt->company->tax_number,
                        ],
                        'cac:PartyName' => [
                            'cbc:Name' => $receipt->company->company_name,
                        ],
                        'cac:PostalAddress' => [
                            'cbc:CityName' => $receipt->company->city,
                            'cbc:CountrySubentity' => $receipt->company->country,
                            'cbc:StreetName' => $receipt->company->address,
                        ],
                        'cac:PartyTaxScheme' => [
                            'cbc:CompanyID' => $receipt->company->tax_number,
                            'cbc:TaxOffice' => $receipt->company->tax_office,
                        ],
                        'cac:Contact' => [
                            'cbc:ElectronicMail' => $receipt->company->email,
                            'cbc:WebsiteURI' => $receipt->company->website,
                            'cbc:Telephone' => $receipt->company->phone_number,
                        ],
                    ],
                ],
                'cac:AccountingCustomerParty' => [
                    'cac:Party' => [
                        'cac:PartyIdentification' => [
                            'cbc:ID' => $receipt->receiver_tax_number,
                        ],
                        'cac:PartyName' => [
                            'cbc:Name' => $receipt->receiver_name,
                        ],
                        'cac:PostalAddress' => [
                            'cbc:CityName' => $receipt->buyer_city,
                            'cbc:CountrySubentity' => $receipt->buyer_country,
                            'cbc:StreetName' => $receipt->buyer_address,
                        ],
                        'cac:PartyTaxScheme' => [
                            'cbc:CompanyID' => $receipt->receiver_tax_number,
                            'cbc:TaxOffice' => $receipt->receiver_tax_office,
                        ],
                        'cac:Contact' => [
                            'cbc:ElectronicMail' => $receipt->buyer_email,
                            'cbc:Telephone' => $receipt->buyer_mobile_number,
                            'cbc:WebsiteURI' => $receipt->buyer_web_address,
                        ],
                    ],
                ],
                'cac:LegalMonetaryTotal' => [
                    'cbc:LineExtensionAmount' => $receipt->total_product_services,
                    'cbc:TaxExclusiveAmount' => $receipt->total_product_services,
                    'cbc:TaxInclusiveAmount' => $receipt->total_payable,
                    'cbc:AllowanceTotalAmount' => '0',
                    'cbc:ChargeTotalAmount' => '0',
                    'cbc:PayableAmount' => $receipt->total_payable,
                ],
            ];

            $receiptLines = [];
            foreach ($receipt->products as $product) {
                $receiptLines[] = [
                    'cbc:ID' => $product->id,
                    'cbc:InvoicedQuantity' => $product->quantity1,
                    'cbc:LineExtensionAmount' => $product->price,
                    'cac:Item' => [
                        'cbc:Description' => $product->fee_reason,
                        'cac:SellersItemIdentification' => [
                            'cbc:ID' => $product->id,
                        ],
                    ],
                    'cac:Price' => [
                        'cbc:PriceAmount' => $product->price,
                    ],
                ];
            }

            $receiptData['cac:InvoiceLine'] = $receiptLines;

            $outputXMLString = $xmlService->write('Invoice', $receiptData);

            return response()->json([
                'status' => true,
                'data' => $outputXMLString
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error'
            ], 500);
        }
    }
}