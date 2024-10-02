<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\DeliveryNoteDespatchType;
use App\Models\DeliveryNoteInvoiceScenario;
use App\Models\DeliveryNoteSubmissionType;
use App\Models\EledgerCategory;
use App\Models\EledgerPaymentMethod;
use App\Models\EledgerStatus;
use App\Models\EledgerTaxInfo;
use App\Models\EledgerTransactionType;
use App\Models\InvoiceCurrency;
use App\Models\InvoiceScenario;
use Illuminate\Http\Request;
use App\Models\InvoiceSendType;
use App\Models\InvoiceType;
use App\Models\PaymentMethods;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Unit;
use Exception;

class UtilsController extends Controller
{
    
    /** List of Invoice Types
     * @OA\Get(
     *  path="/utils/invoice_send_types",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of invoice send types",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string"),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getInvoiceSendTypes(){
            
        try{
            $items = InvoiceSendType::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

       /** List of Invoice Scenarios
     * @OA\Get(
     *  path="/utils/invoice_scenarios",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of invoice scenarios",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getInvoiceScenarios(){
            
        try{
            $items = InvoiceScenario::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

         /** List of Invoice Types
     * @OA\Get(
     *  path="/utils/invoice_types",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of invoice types",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getInvoiceTypes(){
            
        try{
            $items = InvoiceType::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

           /** List of Invoice Currency
     * @OA\Get(
     *  path="/utils/currencies",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of invoice currencies",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getCurrencies(){
            
        try{
            $items = Currency::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

    /** List of Currences
     * @OA\Get(
     *  path="/utils/units",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of currencies",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getUnits(){
            
        try{
            $items = Unit::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

     /** List of Submission Types
     * @OA\Get(
     *  path="/utils/delivery_note_submission_types",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of delivery note submission types",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getDeliveryNoteSubmissionTypes(){
            
        try{
            $items = DeliveryNoteSubmissionType::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

     /** List of Despatch Types
     * @OA\Get(
     *  path="/utils/delivery_note_despatch_types",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of delivery note submission types",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getDeliveryNoteDespatchTypes(){
            
        try{
            $items = DeliveryNoteDespatchType::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

      /** List of Invoice Scenario
     * @OA\Get(
     *  path="/utils/delivery_note_invoice_scenarios",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List of delivery note invoice scenarios",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getDeliveryNoteInvoiceScenarios(){
            
        try{
            $items = DeliveryNoteInvoiceScenario::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

      /** 
     * @OA\Get(
     *  path="/utils/eledger_categories",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getEledgerCategories(){
            
        try{
            $items = EledgerCategory::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

      /** 
     * @OA\Get(
     *  path="/utils/payment_methods",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getPaymentMethods(){
            
        try{
            $items = PaymentMethods::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

      /** List of Invoice Scenario
     * @OA\Get(
     *  path="/utils/eledger_statuses",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getEledgerStatuses(){
            
        try{
            $items = EledgerStatus::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

      /** 
     * @OA\Get(
     *  path="/utils/eledger_tax_infos",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getEledgerTaxInfos(){
            
        try{
            $items = EledgerTaxInfo::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

      /** List of 
     * @OA\Get(
     *  path="/utils/eledger_transaction_types",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getEledgerTransactionTypes(){
            
        try{
            $items = EledgerTransactionType::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

     /** List of 
     * @OA\Get(
     *  path="/utils/product_categories",
     *  tags={"Utils"},
     *  @OA\Response(
     *     response=200,
     *    description="List",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getProductCategories(){
            
        try{
            $items = ProductCategory::all();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

     /** List of 
     * @OA\Get(
     *  path="/utils/product_subcategories/{id}",
     *  tags={"Utils"},
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the invoice",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *  @OA\Response(
     *     response=200,
     *    description="List",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string",),
     *          )
     *     ),
     * @OA\Response(
     *    response=401,
     *   description="Unauthenticated",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Unauthenticated"),
     *  )
     * ),
     * @OA\Response(
     *   response=500,
     * description="Something went wrong",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="Something went wrong"),
     * )
     * )
     * )
     */

     public function getProductSubCategories($id){


            
        try{
            $items = ProductSubCategory::where("product_category_id",$id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Lists',
                'data' => $items
            ], 200);

        }
        catch(\Exception $e){
           return response()->json([
                'status' => true,
                'message' => 'An error has occured'.$e->getMessage()
            ], 500);
        }

     }

}