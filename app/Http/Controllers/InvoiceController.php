<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Currency;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\InvoiceProducts;
use App\Models\InvoiceDecreaseIncrease;
use Exception;
use Illuminate\Support\Facades\DB;
use Sabre\Xml\Service;

class InvoiceController extends Controller
{
   /**
     * @OA\Post(
     *     path="/user/invoice",
     *     tags={"Invoice"},
     *     summary="Create Invoice",
     *     description="Create Invoice",
     *     operationId="createInvoice",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Create new Invoice",
     *         @OA\JsonContent(
     *             required={"send_type", "invoice_uuid", "invoice_date", "invoice_time", "invoice_id", "invoice_type", "invoice_scenario", "invoice_currency"},
     *             @OA\Property(property="send_type", type="string", example="1"),
     *             @OA\Property(property="invoice_uuid", type="string", example="123456"),
     *             @OA\Property(property="invoice_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="invoice_time", type="string", format="time", example="12:00:00"),
     *             @OA\Property(property="invoice_id", type="string", example="123456"),
     *             @OA\Property(property="invoice_type", type="string", example="1"),
     *             @OA\Property(property="invoice_scenario", type="string", example="1"),
     *             @OA\Property(property="invoice_currency", type="string", example="1"),
     *             @OA\Property(property="exchange_rate", type="string", example="1"),
     *             @OA\Property(property="wildcard_1", type="string", example="1"),
     *             @OA\Property(property="your_tapdk_number", type="string", example="1"),
     *             @OA\Property(property="charge_start_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="charge_start_time", type="string", format="time", example="12:00:00"),
     *             @OA\Property(property="charge_end_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="charge_end_time", type="string", format="time", example="12:00:00"),
     *             @OA\Property(property="plate_number", type="string", example="34ABC123"),
     *             @OA\Property(property="vehicle_id", type="string", example="1"),
     *             @OA\Property(property="esu_report_id", type="string", example="1"),
     *             @OA\Property(property="esu_report_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="esu_report_time", type="string", format="time", example="12:00:00"),
     *             @OA\Property(property="order_number", type="string", example="1"),
     *             @OA\Property(property="order_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="dispatch_number", type="string", example="1"),
     *             @OA\Property(property="dispatch_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="dispatch_time", type="string", format="time", example="12:00:00"),
     *             @OA\Property(property="mode_code", type="string", example="1"),
     *             @OA\Property(property="tr_id_number", type="string", example="1"),
     *             @OA\Property(property="name_declarer", type="string", example="1"),
     *             @OA\Property(property="name", type="string", example="1"),
     *             @OA\Property(property="surname", type="string", example="1"),
     *             @OA\Property(property="nationality", type="string", example="1"),
     *             @OA\Property(property="passport_number", type="string", example="1"),
     *             @OA\Property(property="passport_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="receiver_name", type="string", example="1"),
     *             @OA\Property(property="tax_number", type="string", example="1"),
     *             @OA\Property(property="gib_post_box", type="string", example="1"),
     *             @OA\Property(property="receiver_tapdk_number", type="string", example="1"),
     *             @OA\Property(property="tax_office", type="string", example="1"),
     *             @OA\Property(property="country", type="string", example="1"),
     *             @OA\Property(property="city", type="string", example="1"),
     *             @OA\Property(property="address", type="string", example="1"),
     *             @OA\Property(property="receiver_email", type="string", example="1"),
     *             @OA\Property(property="receiver_web", type="string", example="1"),
     *             @OA\Property(property="receiver_phone", type="string", example="1"),
     *             @OA\Property(property="payment_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="payment_means", type="string", example="1"),
     *             @OA\Property(property="payment_channel_code", type="string", example="1"),
     *             @OA\Property(property="payee_financial_account", type="string", example="1"),
     *             @OA\Property(property="total_products", type="string", example="1"),
     *             @OA\Property(property="total_discount", type="string", example="1"),
     *             @OA\Property(property="total_increase", type="string", example="1"),
     *             @OA\Property(property="zero_zero_one_five_vat", type="string", example="1"),
     *             @OA\Property(property="total_taxes", type="string", example="1"),
     *             @OA\Property(property="bottom_total_discount_rate", type="string", example="1"),
     *             @OA\Property(property="notes", type="string", example="1"),
     *             @OA\Property(property="attachment", type="string", example="1"),
     *             @OA\Property(property="company_id", type="string", example="1"),
     *             @OA\Property(property="products", type="array", @OA\Items(
     *                 @OA\Property(property="product_service", type="string", example="1"),
     *                 @OA\Property(property="quantity", type="string", example="1"),
     *                 @OA\Property(property="unit_measurement", type="string", example="1"),
     *                 @OA\Property(property="price", type="string", example="1"),
     *                 @OA\Property(property="taxable_amount", type="string", example="1"),
     *                 @OA\Property(property="zero_zero_one_five_vat_rate", type="string", example="1"),
     *                 @OA\Property(property="zero_zero_one_five_vat_amount", type="string", example="1"),
     *                 @OA\Property(property="taxline_total", type="string", example="1"),
     *                 @OA\Property(property="payabl_line_total", type="string", example="1"),
     *                 @OA\Property(property="product_category_id", type="string", example="3"),
     *                 @OA\Property(property="product_subcategory_id", type="string", example="1"),
     *                 @OA\Property(property="increase_decrease", type="array", @OA\Items(
     *                     @OA\Property(property="type", type="string", example="1"),
     *                     @OA\Property(property="rate", type="string", example="1"),
     *                     @OA\Property(property="amount", type="string", example="1"),
     *                 ))
     *             )),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Invoice created successfully",
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Invoice creation failed!",
     *     ),
     * )
     */
    public function createInvoice(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'send_type' => 'required|exists:invoice_send_types,id',
            'invoice_uuid' => 'required|unique:invoices,invoice_uuid',
            'invoice_date' => 'required',
            'invoice_time' => 'required',
            'invoice_id' => 'required',
            'invoice_type' => 'required|exists:invoice_types,id',
            'invoice_scenario' => 'required|exists:invoice_scenarios,id',
            'invoice_currency' => 'required|exists:currencies,id',
            'products.*.product_category_id' => 'required|exists:product_categories,id'
        ];

        if ($user->hasRole('admin')) {
            $rules['company_id'] = 'required|exists:companies,id';
        }

        try {
            $validatedData = $request->validate($rules);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message' => 'Validation failed!',
                'errors' => $e->getMessage(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $invoiceData = $request->only([
                'send_type',
                'invoice_uuid',
                'invoice_date',
                'invoice_time',
                'invoice_id',
                'invoice_type',
                'invoice_scenario',
                'invoice_currency',
                'exchange_rate',
                'wildcard_1',
                'your_tapdk_number',
                'charge_start_date',
                'charge_start_time',
                'charge_end_date',
                'charge_end_time',
                'plate_number',
                'vehicle_id',
                'esu_report_id',
                'esu_report_date',
                'esu_report_time',
                'order_number',
                'order_date',
                'dispatch_number',
                'dispatch_date',
                'dispatch_time',
                'mode_code',
                'tr_id_number',
                'name_declarer',
                'name',
                'surname',
                'nationality',
                'passport_number',
                'passport_date',
                'receiver_name',
                'tax_number',
                'gib_post_box',
                'receiver_tapdk_number',
                'tax_office',
                'country',
                'city',
                'address',
                'receiver_email',
                'receiver_web',
                'receiver_phone',
                'payment_date',
                'payment_means',
                'payment_channel_code',
                'payee_financial_account',
                'total_products',
                'total_discount',
                'total_increase',
                'zero_zero_one_five_vat',
                'total_taxes',
                'bottom_total_discount_rate',
                'notes'
            ]);

            $invoice = new Invoice();
            $invoice->fill($invoiceData);
            $invoice->user_id = $user->id;
            $invoice->company_id = $user->hasRole('admin') ? $request->company_id : $user->company_id;
            $invoice->save();

            // Process attachments...

            // Process invoice products...
            foreach ($request->products as $productData) {
                $invoiceProduct = new InvoiceProducts();
                $invoiceProduct->fill($productData);
                $invoice->products()->save($invoiceProduct);

                // Process decrease/increase...
                $decreaseIncreaseData = $productData['increase_decrease'];
                foreach ($decreaseIncreaseData as $decreaseIncrease) {
                    $invoiceDecreaseIncrease = new InvoiceDecreaseIncrease();
                    $invoiceDecreaseIncrease->fill($decreaseIncrease);

                    // Associate with the corresponding invoice product
                    $invoiceDecreaseIncrease->invoice_product_id = $invoiceProduct->id;

                    $invoiceDecreaseIncrease->save();
                }
            }

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Invoice created successfully',
                'invoice' => $invoice
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

             return response()->json([
                'status'=>false,
                'message' => 'Server Error'.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/user/invoice",
     *     tags={"Invoice"},
     *     summary="Get Invoices",
     *     description="Get Invoices",
     *     operationId="getInvoices",
     *     @OA\Response(
     *         response=200,
     *         description="Invoices fetched successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Invoices fetched successfully!"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to fetch invoices!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to fetch invoices!")
     *         )
     *     )
     * )
     */
    public function getInvoices($limit = 10,)
    {
        $user = auth()->user();

        try {
            $invoices = Invoice::where('user_id', $user->id)
                ->with([
                    'products.decreaseIncrease',
                    'products.productCategory',
                    'products.productSubCategory'
                ])->paginate($limit);

            return response()->json([
                'status'=>true,
                'message' => 'Invoices fetched successfully!',
                'data' => $invoices
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch invoices!',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *    path="/user/invoice/{id}",
     *   tags={"Invoice"},
     *  summary="Get Invoice",
     * description="Get Invoice",
     * operationId="getInvoice",
     * @OA\Parameter(
     *    name="id",
     *  in="path",
     * description="ID of the invoice",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Invoice fetched successfully!",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Invoice fetched successfully!"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     *  response=404,
     * description="Invoice not found!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Invoice not found!")
     * )
     * )
     * )
     */
    public function getInvoice($invoiceId)
    {

        $user = auth()->user();

        $invoice = Invoice::where('user_id', $user->id)
             ->with('products.decreaseIncrease','products.productCategory', 'products.productCategory.productSubCategory')
            ->find($invoiceId);


        if (!$invoice) {
            return response()->json([
               'status'=>false,
                'message' => 'Invoice not found!'
            ], 404);
        }

        return response()->json([
            'status'=>true,
            'message' => 'Invoice fetched successfully!',
            'data' => $invoice
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/user/invoice/{id}",
     *     tags={"Invoice"},
     *     summary="Update Invoice",
     *     description="Update Invoice",
     *     operationId="updateInvoice",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the invoice",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update Invoice",
     *         @OA\JsonContent(
     *             required={"send_type", "invoice_uuid", "invoice_date", "invoice_time", "invoice_id", "invoice_type", "invoice_scenario", "invoice_currency"},
     *             @OA\Property(property="send_type", type="string", example="1"),
     *             @OA\Property(property="invoice_uuid", type="string", example="123456"),
     *             @OA\Property(property="invoice_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="invoice_time", type="string", format="time", example="12:00:00"),
     *             @OA\Property(property="invoice_id", type="string", example="123456"),
     *             @OA\Property(property="invoice_type", type="string", example="1"),
     *             @OA\Property(property="invoice_scenario", type="string", example="1"),
     *             @OA\Property(property="invoice_currency", type="string", example="1"),
     *             @OA\Property(property="exchange_rate", type="string", example="1"),
     *             @OA\Property(property="wildcard_1", type="string", example="1"),
     *             @OA\Property(property="your_tapdk_number", type="string", example="1"),
     *             @OA\Property(property="charge_start_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="charge_start_time", type="string", format="time", example="12:00:00"),
     *             @OA\Property(property="charge_end_date", type="string", format="date", example="2021-09-01"),
     *            @OA\Property(property="charge_end_time", type="string", format="time", example="12:00:00"),
     *            @OA\Property(property="plate_number", type="string", example="34ABC123"),
     *           @OA\Property(property="vehicle_id", type="string", example="1"),
     *          @OA\Property(property="esu_report_id", type="string", example="1"),
     *        @OA\Property(property="esu_report_date", type="string", format="date", example="2021-09-01"),
     *      @OA\Property(property="esu_report_time", type="string", format="time", example="12:00:00"),
     *    @OA\Property(property="order_number", type="string", example="1"),
     * @OA\Property(property="order_date", type="string", format="date", example="2021-09-01"),
     * @OA\Property(property="dispatch_number", type="string", example="1"),
     * @OA\Property(property="dispatch_date", type="string", format="date", example="2021-09-01"),
     * @OA\Property(property="dispatch_time", type="string", format="time", example="12:00:00"),
     * @OA\Property(property="mode_code", type="string", example="1"),
     * @OA\Property(property="tr_id_number", type="string", example="1"),
     * @OA\Property(property="name_declarer", type="string", example="1"),
     * @OA\Property(property="name", type="string", example="1"),
     * @OA\Property(property="surname", type="string", example="1"),
     * @OA\Property(property="national", type="string", example="1"),
     * @OA\Property(property="passport_number", type="string", example="1"),
     * @OA\Property(property="passport_date", type="string", format="date", example="2021-09-01"),
     * @OA\Property(property="receiver_name", type="string", example="1"),
     * @OA\Property(property="tax_number", type="string", example="1"),
     * @OA\Property(property="gib_post_box", type="string", example="1"),
     * @OA\Property(property="receiver_tapdk_number", type="string", example="1"),
     * @OA\Property(property="tax_office", type="string", example="1"),
     * @OA\Property(property="country", type="string", example="1"),
     * @OA\Property(property="city", type="string", example="1"),
     * @OA\Property(property="address", type="string", example="1"),
     * @OA\Property(property="receiver_email", type="string", example="1"),
     * @OA\Property(property="receiver_web", type="string", example="1"),
     * @OA\Property(property="receiver_phone", type="string", example="1"),
     * @OA\Property(property="payment_date", type="string", format="date", example="2021-09-01"),
     * @OA\Property(property="payment_means", type="string", example="1"),
     * @OA\Property(property="payment_channel_code", type="string", example="1"),
     * @OA\Property(property="payee_financial_account", type="string", example="1"),
     * @OA\Property(property="total_products", type="string", example="1"),
     * @OA\Property(property="total_discount", type="string", example="1"),
     * @OA\Property(property="total_increase", type="string", example="1"),
     * @OA\Property(property="zero_zero_one_five_vat", type="string", example="1"),
     * @OA\Property(property="total_taxes", type="string", example="1"),
     * @OA\Property(property="bottom_total_discount_rate", type="string", example="1"),
     * @OA\Property(property="notes", type="string", example="1"),
     * @OA\Property(property="attachment", type="string", example="1"),
    *  @OA\Property(property="company_id", type="string", example="1"),
     * @OA\Property(property="products", type="array", @OA\Items(
    
     *    @OA\Property(property="product_service", type="string", example="1"),
     *  @OA\Property(property="quantity", type="string", example="1"),
     * @OA\Property(property="unit_measurement", type="string", example="1"),
     * @OA\Property(property="price", type="string", example="1"),
     * @OA\Property(property="taxable_amount", type="string", example="1"),
     * @OA\Property(property="zero_zero_one_five_vat_rate", type="string", example="1"),
     * @OA\Property(property="zero_zero_one_five_vat_amount", type="string", example="1"),
     * @OA\Property(property="taxline_total", type="string", example="1"),
     * @OA\Property(property="payabl_line_total", type="string", example="1"),
     * @OA\Property(property="product_category_id", type="string", example="3"),
     * @OA\Property(property="product_subcategory_id", type="string", example="1"),
     * @OA\Property(property="increase_decrease", type="array", @OA\Items(
     *   @OA\Property(property="type", type="string", example="1"),
     * @OA\Property(property="rate", type="string", example="1"),
     * @OA\Property(property="amount", type="string", example="1"),
     * ))
     * ))
     *        ),
     *   ),
     *  @OA\Response(
     *    response=200,
     * description="Invoice updated successfully!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Invoice updated successfully!"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Invoice not found!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Invoice not found!")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Failed to update invoice!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Failed to update invoice!")
     * )
     * )
     * )
     */
    public function update(Request $request, $invoiceId)
    {
        $user = auth()->user();

        $invoice = Invoice::where('user_id', $user->id)
            ->find($invoiceId);

        if (!$invoice) {
            return response()->json([
               'status'=>false,
                'message' => 'Invoice not found!'
            ], 404);
        }

         $rules = [
            'send_type' => 'required|exists:invoice_send_types,id',
            'invoice_uuid' => 'required|unique:invoices,invoice_uuid,'.$invoice->id,
            'invoice_date' => 'required',
            'invoice_time' => 'required',
            'invoice_id' => 'required',
            'invoice_type' => 'required|exists:invoice_types,id',
            'invoice_scenario' => 'required|exists:invoice_scenarios,id',
            'invoice_currency' => 'required|exists:currencies,id',
            'products.*.product_category_id' => 'required|exists:product_categories,id'
        ];

        if ($user->hasRole('admin')) {
            $rules['company_id'] = 'required|exists:companies,id';
        }

        try {
            $validatedData = $request->validate($rules);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message' => 'Validation failed!',
                'errors' => $e->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $invoiceData = $request->only([
                'send_type',
                'invoice_uuid',
                'invoice_date',
                'invoice_time',
                'invoice_id',
                'invoice_type',
                'invoice_scenario',
                'invoice_currency',
                'exchange_rate',
                'wildcard_1',
                'your_tapdk_number',
                'charge_start_date',
                'charge_start_time',
                'charge_end_date',
                'charge_end_time',
                'plate_number',
                'vehicle_id',
                'esu_report_id',
                'esu_report_date',
                'esu_report_time',
                'order_number',
                'order_date',
                'dispatch_number',
                'dispatch_date',
                'dispatch_time',
                'mode_code',
                'tr_id_number',
                'name_declarer',
                'name',
                'surname',
                'nationality',
                'passport_number',
                'passport_date',
                'receiver_name',
                'tax_number',
                'gib_post_box',
                'receiver_tapdk_number',
                'tax_office',
                'country',
                'city',
                'address',
                'receiver_email',
                'receiver_web',
                'receiver_phone',
                'payment_date',
                'payment_means',
                'payment_channel_code',
                'payee_financial_account',
                'total_products',
                'total_discount',
                'total_increase',
                'zero_zero_one_five_vat',
                'total_taxes',
                'bottom_total_discount_rate',
                'notes'
            ]);

            $invoice->fill($invoiceData);
            $user->hasRole('admin') &&  $invoice->company_id = $request->company_id;
            $invoice->save();

            // Process attachments...

            // Process invoice products...
            $invoice->products()->delete();
            foreach ($request->products as $productData) {
                $invoiceProduct = new InvoiceProducts();
                $invoiceProduct->fill($productData);
                $invoice->products()->save($invoiceProduct);

                // Process decrease/increase...
                $decreaseIncreaseData = $productData['increase_decrease'];
                // Delete existing decrease/increase data
                foreach ($decreaseIncreaseData as $decreaseIncrease) {
                    $invoiceDecreaseIncrease = new InvoiceDecreaseIncrease();
                    $invoiceDecreaseIncrease->fill($decreaseIncrease);

                    // Associate with the corresponding invoice product
                    $invoiceDecreaseIncrease->invoice_product_id = $invoiceProduct->id;

                    $invoiceDecreaseIncrease->save();
                }
            }

            DB::commit();

            return response()->json([
                'status'=>true,
                'message' => 'Invoice updated successfully!',
                'data' => $invoice
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

             return response()->json([
                'status'=>false,
                'message' => 'Server Error',
            ], 500);
        }


    }


    public function delete($invoiceId)
    {
        $user = auth()->user();

        $invoice = Invoice::where('user_id', $user->id)
            ->find($invoiceId);

        if (!$invoice) {
            return response()->json([
               'status'=>false,
                'message' => 'Invoice not found!'
            ], 404);
        }

        try {
            $invoice->delete();

            return response()->json([
                'status'=>true,
                'message' => 'Invoice deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
               'status'=>false,
                'message' => 'Failed to delete invoice!'
            ], 500);
        }
    }

    public function generateUbl($invoiceId)
    {
        $user = auth()->user();

        $invoice = Invoice::where('user_id', $user->id)
            ->with('products.decreaseIncrease', 'company', 'currency', 'sendType', 'type', 'scenario')
            ->find($invoiceId);

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found!'
            ], 404);
        }

        $xmlService = new Service();
        $xmlService->namespaceMap = [
            'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2' => '',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
        ];

        $invoiceData = [
            'cbc:UBLVersionID'=>'2.1',
            'cbc:CustomizationID'=>'TR1.2',
            'cbc:ProfileID'=>'TEMELFATURA',
            'cbc:ID' => $invoice->invoice_id,
            'cbc:CopyIndicator' => 'false',
            'cbc:UUID'=>$invoice->invoice_uuid,
            'cbc:IssueDate' => $invoice->invoice_date,
            'cbc:IssueTime' => $invoice->invoice_time,
            'cbc:InvoiceTypeCode' => $invoice->type->name,
            'cbc:DocumentCurrencyCode'=>$invoice->currency->code,
            'cac:AccountingSupplierParty' => [
                'cac:Party' => [
                    'cac:PartyIdentification' => [
                        'cbc:ID' => $invoice->company->tax_number,
                        'cbc:ID' => $invoice->company->gib_post_box,
                        'cbc:ID' => $invoice->company->receiver_tapdk_number,
                    ],
                    'cac:PartyName' => [
                        'cbc:Name' => $invoice->company->company_name,
                    ],
                    'cac:PostalAddress' => [
                        'cbc:CityName' => $invoice->company->city,
                        'cbc:CountrySubentity' => $invoice->company->country,
                        'cbc:StreetName' => $invoice->company->address,
                    ],
                    'cac:PartyTaxScheme' => [
                        'cbc:CompanyID' => $invoice->company->tax_number,
                        'cbc:TaxOffice' => $invoice->company->tax_office,
                    ],
                    'cac:Contact' => [
                        'cbc:ElectronicMail' => $invoice->company->email,
                        'cbc:WebsiteURI' => $invoice->company->website,
                        'cbc:Telephone' => $invoice->company->phone_number,
                    ],
                ],
            ],
            'cac:AccountingCustomerParty' => [
                'cac:Party' => [
                    'cac:PartyIdentification' => [
                        'cbc:ID' => $invoice->tax_number,
                        'cbc:ID' => $invoice->gib_post_box,
                        'cbc:ID' => $invoice->receiver_tapdk_number,
                    ],
                    'cac:PartyName' => [
                        'cbc:Name' => $invoice->receiver_name,
                    ],
                    'cac:PostalAddress' => [
                        'cbc:CityName' => $invoice->city,
                        'cbc:CountrySubentity' => $invoice->country,
                        'cbc:StreetName' => $invoice->address,
                    ],
                    'cac:PartyTaxScheme' => [
                        'cbc:CompanyID' => $invoice->tax_number,
                        'cbc:TaxOffice' => $invoice->tax_office,
                    ],
                    'cac:Contact' => [
                        'cbc:ElectronicMail' => $invoice->receiver_email,
                        'cbc:WebsiteURI' => $invoice->receiver_web,
                        'cbc:Telephone' => $invoice->receiver_phone,
                    ],
                ],
            ],
            'cac:PaymentMeans' => [
                'cbc:PaymentMeansCode' => $invoice->payment_channel_code,
                'cbc:PaymentDueDate' => $invoice->payment_date,
                'cac:PayeeFinancialAccount' => [
                    'cbc:ID' => $invoice->payee_financial_account,
                ],
            ],
            'cac:TaxTotal' => [
                'cbc:TaxAmount' => $invoice->total_taxes,
                'cac:TaxSubtotal' => [
                    'cbc:TaxableAmount' => $invoice->total_products,
                    'cbc:TaxAmount' => $invoice->total_taxes,
                    'cbc:Percent' => $invoice->zero_zero_one_five_vat,
                    'cac:TaxCategory' => [
                        'cbc:TaxExemptionReason' => 'KDV',
                        'cbc:TaxScheme' => [
                            'cbc:ID' => 'KDV',
                            'cbc:Name' => 'KDV',
                        ],
                    ],
                ],
            ],
            'cac:LegalMonetaryTotal' => [
                'cbc:LineExtensionAmount' => $invoice->total_products,
                'cbc:TaxExclusiveAmount' => $invoice->total_products,
                'cbc:TaxInclusiveAmount' => $invoice->total_products,
                'cbc:AllowanceTotalAmount' => $invoice->total_discount,
                'cbc:ChargeTotalAmount' => $invoice->total_increase,
                'cbc:PayableAmount' => $invoice->payabl_line_total,
            ],
            // Add more invoice fields here
        ];

        $invoiceLines = [];
        foreach ($invoice->products as $product) {
            $invoiceLines[] = [
                'cbc:ID' => $product->id,
                'cbc:InvoicedQuantity' => $product->quantity,
                'cbc:LineExtensionAmount' => $product->price,
                'cac:Item' => [
                    'cbc:Description' => $product->product_service,
                    'cac:SellersItemIdentification' => [
                        'cbc:ID' => $product->id,
                    ],
                    // Add more product fields here
                ],
                'cac:Price' => [
                    'cbc:PriceAmount' => $product->price,
                ],

                // Add more invoice line fields here
            ];
        }

        $invoiceData['cac:InvoiceLine'] = $invoiceLines;

        $outputXMLString = $xmlService->write('Invoice', $invoiceData);

        //  You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'data' =>  $outputXMLString
        ]);

    }

    public function getSendType(Request $request)
    {
        try {
            $request->validate([
                'receiver_email' => 'required|email',
                'invoice_uuid' => 'required|string',
            ]);
    
            \Log::info('Request validated successfully', [
                'receiver_email' => $request->receiver_email,
                'invoice_uuid' => $request->invoice_uuid,
            ]);
    
            $invoice = new Invoice();
            $sendType = $invoice->getSendTypeByEmailAndUuid($request->receiver_email, $request->invoice_uuid);
    
            \Log::info('Send type retrieved', ['send_type' => $sendType]);
    
            if ($sendType) {
                return response()->json([
                    'status' => 200,
                    'send_type' => $sendType,
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No matching invoice found.',
                ], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Error in getSendType method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
    
    


}





