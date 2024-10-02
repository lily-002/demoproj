<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use App\Models\DeliveryNoteDriverInfo;
use App\Models\DeliveryNoteProduct;
use App\Models\DeliveryNoteTrailerInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sabre\Xml\Service;

class DeliveryNoteController extends Controller
{
    

    /**
     * @OA\Post(
     *     path="/user/delivery-note",
     *     tags={"Delivery Note"},
     *     summary="Create a new delivery note",
     *     description="Create a new delivery note",  
     *     operationId="createDeliveryNote",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Delivery note data",
     *         @OA\JsonContent(
     *             required={"submission_type_id", "despatch_date", "despatch_type_id", "invoice_scenario_id", "currency_unit_id"},
     *             @OA\Property(property="invoice_uuid", type="string", example="123456"),
     *             @OA\Property(property="submission_type_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="despatch_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="despatch_type_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="invoice_scenario_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="currency_unit_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="carrier_title", type="string", example="Carrier title"),
     *             @OA\Property(property="carrier_tin", type="string", example="Carrier tin"),
     *             @OA\Property(property="vehicle_plate_number", type="string", example="Vehicle plate number"),
     *             @OA\Property(property="total_amount", type="number", format="float", example=100.00),
     *             @OA\Property(property="wild_card1", type="string", example="Wild card 1"),
     *             @OA\Property(property="receiver_name", type="string", example="Receiver name"),
     *             @OA\Property(property="receiver_tax_number", type="string", example="Receiver tax number"),
     *             @OA\Property(property="receiver_gib_postacute", type="string", example="Receiver gib postacute"),
     *             @OA\Property(property="receiver_tax_office", type="string", example="Receiver tax office"),
     *             @OA\Property(property="receiver_country", type="string", example="Receiver country"),
     *             @OA\Property(property="receiver_city", type="string", example="Receiver city"),
     *             @OA\Property(property="receiver_destrict", type="string", example="Receiver destrict"),
     *             @OA\Property(property="receiver_address", type="string", example="Receiver address"),
     *             @OA\Property(property="receiver_mobile_number", type="string", example="Receiver mobile number"),
     *             @OA\Property(property="real_buyer", type="string", example="Real buyer"),
     *             @OA\Property(property="buyer_tax_number", type="string", example="Buyer tax number"),
     *             @OA\Property(property="buyer_tax_admin", type="string", example="Buyer tax admin"),
     *             @OA\Property(property="buyer_tax_office", type="string", example="Buyer tax office"),
     *             @OA\Property(property="buyer_country", type="string", example="Buyer country"),
     *             @OA\Property(property="buyer_city", type="string", example="Buyer city"),
     *             @OA\Property(property="buyer_destrict", type="string", example="Buyer destrict"),
     *             @OA\Property(property="buyer_address", type="string", example="Buyer address"),
     *             @OA\Property(property="real_seller", type="string", example="Real seller"),
     *             @OA\Property(property="seller_tax_number", type="string", example="Seller tax number"),
     *             @OA\Property(property="seller_tax_admin", type="string", example="Seller tax admin"),
     *             @OA\Property(property="seller_tax_office", type="string", example="Seller tax office"),
     *             @OA\Property(property="seller_country", type="string", example="Seller country"),
     *             @OA\Property(property="seller_city", type="string", example="Seller city"),
     *             @OA\Property(property="seller_destrict", type="string", example="Seller destrict"),
     *             @OA\Property(property="seller_address", type="string", example="Seller address"),
     *             @OA\Property(property="order_number", type="string", example="Order number"),
     *             @OA\Property(property="order_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="shipment_time", type="string", example="Shipment time"),
     *             @OA\Property(property="additional_document_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="second_receiver_country", type="string", example="Second receiver country"),
     *             @OA\Property(property="second_receiver_ill", type="string", example="Second receiver ill"),
     *             @OA\Property(property="second_receiver_postal_code", type="string", example="Second receiver postal code"),
     *             @OA\Property(property="second_receiver_district", type="string", example="Second receiver district"),
     *             @OA\Property(property="second_receiver_address", type="string", example="Second receiver address"),
     *             @OA\Property(property="notes", type="string", example="Notes"),
     *             @OA\Property(property="company_id", type="string", example="1"),
     *             @OA\Property(property="products", type="array", @OA\Items(
     *                 @OA\Property(property="product_service", type="string", example="Product service"),
     *                 @OA\Property(property="quantity_one", type="number", format="float", example=1.00),
     *                 @OA\Property(property="unit_id_one", type="integer", format="int64", example=1),
     *                 @OA\Property(property="quantity_two", type="number", format="float", example=1.00),
     *                 @OA\Property(property="unit_id_two", type="integer", format="int64", example=1),
     *                 @OA\Property(property="price", type="number", format="float", example=1.00),
     *                 @OA\Property(property="product_amount", type="number", format="float", example=1.00),
     *                 @OA\Property(property="product_category_id", type="string", example="3"),
     *                 @OA\Property(property="product_subcategory_id", type="string", example="1"),
     *             )),
     *             @OA\Property(property="drivers", type="array", @OA\Items(
     *                 @OA\Property(property="name", type="string", example="Driver name"),
     *                 @OA\Property(property="surname", type="string", example="Driver surname"),
     *                 @OA\Property(property="tckn", type="string", example="Driver tckn number"),
     *             )),
     *             @OA\Property(property="trailers", type="array", @OA\Items(
     *                 @OA\Property(property="plate_number", type="string", example="Plate Number"),
     *             )),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Note created successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Note creation failed!",
     *     ),
     * ),
     */

    public function createDeliveryNote(Request $request){

         $user = auth()->user();

         $rules = [
            'invoice_uuid' => 'unique:edelivery_note_table,invoice_uuid',
            'submission_type_id' => 'required|numeric|exists:edelivery_note_submission_type,id',
            'despatch_date' => 'required',
            'despatch_type_id' => 'required|numeric|exists:edelivery_note_despatch_type,id',
            'invoice_scenario_id' => 'required|numeric|exists:edelivery_note_invoice_scenario,id',
            'currency_unit_id' => 'required|numeric|exists:currencies,id',
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

         try{
            DB::beginTransaction();

            $deliveryNoteData = $request->only([
                'invoice_uuid',
                'submission_type_id',
                'despatch_date',
                'despatch_id',
                'despatch_type_id',
                'invoice_scenario_id',
                'currency_unit_id',
                'carrier_title',
                'carrier_tin',
                'vehicle_plate_number',
                'total_amount',
                'wild_card1',
                'receiver_name',
                'receiver_tax_number',
                'receiver_gib_postacute',
                'receiver_tax_office',
                'receiver_country',
                'receiver_city',
                'receiver_destrict',
                'receiver_address',
                'receiver_mobile_number',
                'real_buyer',
                'buyer_tax_number',
                'buyer_tax_admin',
                'buyer_tax_office',
                'buyer_country',
                'buyer_city',
                'buyer_destrict',
                'buyer_address',
                'real_seller',
                'seller_tax_number',
                'seller_tax_admin',
                'seller_tax_office',
                'seller_country',
                'seller_city',
                'seller_destrict',
                'seller_address',
                'order_number',
                'order_date',
                'shipment_time',
                'additional_document_id',
                'second_receiver_country',
                'second_receiver_ill',
                'second_receiver_postal_code',
                'second_receiver_district',
                'second_receiver_address',
                'notes',
            ]);


            $deliveryNote = new DeliveryNote();
            $deliveryNote->fill($deliveryNoteData);
            $deliveryNote->user_id = $user->id;
            $deliveryNote->company_id = $user->hasRole('admin') ? $request->company_id : $user->company_id;
            $deliveryNote->save();
            

            // Process products..
            foreach($request->products as $productData){
                $product = new DeliveryNoteProduct();
                $product->fill($productData);
                $deliveryNote->products()->save($product);
            }

            // Process drivers...
            foreach($request->drivers as $driverData){
                $driver = new DeliveryNoteDriverInfo();
                $driver->fill($driverData);
                $deliveryNote->drivers()->save($driver);
            }

            // Process trailer...
            foreach($request->trailers as $trailerData){
                
                $trailer = new DeliveryNoteTrailerInfo();
                $trailer->fill($trailerData);
                
                $deliveryNote->trailers()->save($trailer);
            }

            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Note created successfully',
                'invoice' => $deliveryNote
            ], 201);



         }catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => 'Note creation failed!',
            'error' => $e->getMessage()
        ], 500);
    }


    }

    /**
     * @OA\Get(
     *     path="/user/delivery-note",
     *     tags={"Delivery Note"},
     *     summary="Get Delivery Notes",
     *     description="Get Delivery Notes",
     *     operationId="getDeliveryNotes",
     *     @OA\Response(
     *         response=200,
     *         description="Delivery Notes fetched successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Delivery Notes fetched successfully!"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to fetch notes!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to fetch notes!")
     *         )
     *     )
     * )
     */
    public function getDeliveryNotes($limit = 10,)
    {
        $user = auth()->user();

        try {
            $notes = DeliveryNote::where('user_id', $user->id)
                 ->with("products","drivers","trailers",'products.productCategory', 'products.productCategory.productSubCategory')
                ->paginate($limit);

            return response()->json([
                'status'=>true,
                'message' => 'Notes fetched successfully!',
                'data' => $notes
            ], 200);
        } catch (\Exception $e) {
             return response()->json([
                'status'=>false,
                'message' => 'Server Error',
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *    path="/user/delivery-note/{id}",
     *   tags={"Delivery Note"},
     *  summary="Get Delivery Note",
     * description="Get Delivery Note",
     * operationId="getDeliveryNote",
     * @OA\Parameter(
     *    name="id",
     *  in="path",
     * description="ID of the note",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Note fetched successfully!",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Note fetched successfully!"),
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
    public function getDeliveryNote($id)
    {

        $user = auth()->user();

        $note = DeliveryNote::where('user_id', $user->id)
                ->with("products","drivers","trailers",'products.productCategory', 'products.productCategory.productSubCategory')
            ->find($id);


        if (!$note) {
            return response()->json([
               'status'=>false,
                'message' => 'Note not found!'
            ], 404);
        }

        return response()->json([
            'status'=>true,
            'message' => 'Note fetched successfully!',
            'data' => $note
        ], 200);
    }

      /**
     * @OA\Put(
     *     path="/user/delivery-note/{id}",
     *     tags={"Delivery Note"},
     *     summary="Update delivery note",
     *     description="Update delivery note",  
     *     operationId="updateDeliveryNote",
     *    @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the note",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Delivery note data",
     *         @OA\JsonContent(
     *             required={"submission_type_id", "despatch_date", "despatch_type_id", "invoice_scenario_id", "currency_unit_id"},
     *             @OA\Property(property="invoice_uuid", type="string", example="123456"),
     *             @OA\Property(property="submission_type_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="despatch_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="despatch_type_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="invoice_scenario_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="currency_unit_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="carrier_title", type="string", example="Carrier title"),
     *             @OA\Property(property="carrier_tin", type="string", example="Carrier tin"),
     *             @OA\Property(property="vehicle_plate_number", type="string", example="Vehicle plate number"),
     *             @OA\Property(property="total_amount", type="number", format="float", example=100.00),
     *             @OA\Property(property="wild_card1", type="string", example="Wild card 1"),
     *             @OA\Property(property="receiver_name", type="string", example="Receiver name"),
     *             @OA\Property(property="receiver_tax_number", type="string", example="Receiver tax number"),
     *             @OA\Property(property="receiver_gib_postacute", type="string", example="Receiver gib postacute"),
     *             @OA\Property(property="receiver_tax_office", type="string", example="Receiver tax office"),
     *             @OA\Property(property="receiver_country", type="string", example="Receiver country"),
     *             @OA\Property(property="receiver_city", type="string", example="Receiver city"),
     *             @OA\Property(property="receiver_destrict", type="string", example="Receiver destrict"),
     *             @OA\Property(property="receiver_address", type="string", example="Receiver address"),
     *             @OA\Property(property="receiver_mobile_number", type="string", example="Receiver mobile number"),
     *             @OA\Property(property="real_buyer", type="string", example="Real buyer"),
     *             @OA\Property(property="buyer_tax_number", type="string", example="Buyer tax number"),
     *             @OA\Property(property="buyer_tax_admin", type="string", example="Buyer tax admin"),
     *             @OA\Property(property="buyer_tax_office", type="string", example="Buyer tax office"),
     *             @OA\Property(property="buyer_country", type="string", example="Buyer country"),
     *             @OA\Property(property="buyer_city", type="string", example="Buyer city"),
     *             @OA\Property(property="buyer_destrict", type="string", example="Buyer destrict"),
     *             @OA\Property(property="buyer_address", type="string", example="Buyer address"),
     *             @OA\Property(property="real_seller", type="string", example="Real seller"),
     *             @OA\Property(property="seller_tax_number", type="string", example="Seller tax number"),
     *             @OA\Property(property="seller_tax_admin", type="string", example="Seller tax admin"),
     *             @OA\Property(property="seller_tax_office", type="string", example="Seller tax office"),
     *             @OA\Property(property="seller_country", type="string", example="Seller country"),
     *             @OA\Property(property="seller_city", type="string", example="Seller city"),
     *             @OA\Property(property="seller_destrict", type="string", example="Seller destrict"),
     *             @OA\Property(property="seller_address", type="string", example="Seller address"),
     *             @OA\Property(property="order_number", type="string", example="Order number"),
     *             @OA\Property(property="order_date", type="string", format="date", example="2021-09-01"),
     *             @OA\Property(property="shipment_time", type="string", example="Shipment time"),
     *             @OA\Property(property="additional_document_id", type="integer", format="int64", example=1),
     *             @OA\Property(property="second_receiver_country", type="string", example="Second receiver country"),
     *             @OA\Property(property="second_receiver_ill", type="string", example="Second receiver ill"),
     *             @OA\Property(property="second_receiver_postal_code", type="string", example="Second receiver postal code"),
     *             @OA\Property(property="second_receiver_district", type="string", example="Second receiver district"),
     *             @OA\Property(property="second_receiver_address", type="string", example="Second receiver address"),
     *             @OA\Property(property="notes", type="string", example="Notes"),
     *             @OA\Property(property="company_id", type="string", example="1"),
     *             @OA\Property(property="products", type="array", @OA\Items(
     *                 @OA\Property(property="product_service", type="string", example="Product service"),
     *                 @OA\Property(property="quantity_one", type="number", format="float", example=1.00),
     *                 @OA\Property(property="unit_id_one", type="integer", format="int64", example=1),
     *                 @OA\Property(property="quantity_two", type="number", format="float", example=1.00),
     *                 @OA\Property(property="unit_id_two", type="integer", format="int64", example=1),
     *                 @OA\Property(property="price", type="number", format="float", example=1.00),
     *                 @OA\Property(property="product_amount", type="number", format="float", example=1.00),
     *                 @OA\Property(property="product_category_id", type="string", example="3"),
     *                 @OA\Property(property="product_subcategory_id", type="string", example="1"),
     *             )),
     *             @OA\Property(property="drivers", type="array", @OA\Items(
     *                 @OA\Property(property="name", type="string", example="Driver name"),
     *                 @OA\Property(property="surname", type="string", example="Driver surname"),
     *                 @OA\Property(property="tckn", type="string", example="Driver tckn number"),
     *             )),
     *             @OA\Property(property="trailers", type="array", @OA\Items(
     *                 @OA\Property(property="plate_number", type="string", example="Plate Number"),
     *             )),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note updated successfully",
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Note not found!",
     *      ),
     *     @OA\Response(
     *         response=500,
     *         description="Note updation failed!",
     *     ),
     * ),
     */

     public function updateDeliveryNote(Request $request, $id)
    {
        $user = auth()->user();

        $deliveryNote = DeliveryNote::where('user_id', $user->id)->with("products", "drivers","trailers")
            ->find($id);

        if (!$deliveryNote) {
            return response()->json([
               'status'=>false,
                'message' => 'Note not found!'
            ], 404);
        }

        $rules = [
            'invoice_uuid' => 'required|unique:edelivery_note_table,invoice_uuid,'.$deliveryNote->id,
            'submission_type_id' => 'required|numeric|exists:edelivery_note_submission_type,id',
            'despatch_date' => 'required',
            'despatch_type_id' => 'required|numeric|exists:edelivery_note_despatch_type,id',
            'invoice_scenario_id' => 'required|numeric|exists:edelivery_note_invoice_scenario,id',
            'currency_unit_id' => 'required|numeric|exists:currencies,id',
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
         try{
            DB::beginTransaction();

            $deliveryNoteData = $request->only([
                'invoice_uuid',
                'submission_type_id',
                'despatch_date',
                'despatch_id',
                'despatch_type_id',
                'invoice_scenario_id',
                'currency_unit_id',
                'carrier_title',
                'carrier_tin',
                'vehicle_plate_number',
                'total_amount',
                'wild_card1',
                'receiver_name',
                'receiver_tax_number',
                'receiver_gib_postacute',
                'receiver_tax_office',
                'receiver_country',
                'receiver_city',
                'receiver_destrict',
                'receiver_address',
                'receiver_mobile_number',
                'real_buyer',
                'buyer_tax_number',
                'buyer_tax_admin',
                'buyer_tax_office',
                'buyer_country',
                'buyer_city',
                'buyer_destrict',
                'buyer_address',
                'real_seller',
                'seller_tax_number',
                'seller_tax_admin',
                'seller_tax_office',
                'seller_country',
                'seller_city',
                'seller_destrict',
                'seller_address',
                'order_number',
                'order_date',
                'shipment_time',
                'additional_document_id',
                'second_receiver_country',
                'second_receiver_ill',
                'second_receiver_postal_code',
                'second_receiver_district',
                'second_receiver_address',
                'notes',
            ]);


            $deliveryNote->fill($deliveryNoteData);
            $deliveryNote->company_id = $user->hasRole('admin') ? $request->company_id : $user->company_id;
            $deliveryNote->save();
            

            // Process products..
            $deliveryNote->products()->delete();
            foreach($request->products as $productData){
                $product = new DeliveryNoteProduct();
                $product->fill($productData);
                $deliveryNote->products()->save($product);
            }

            // Process drivers...
            $deliveryNote->drivers()->delete();
            foreach($request->drivers as $driverData){
                $driver = new DeliveryNoteDriverInfo();
                $driver->fill($driverData);
                $deliveryNote->drivers()->save($driver);
            }

            // Process trailer...
            $deliveryNote->trailers()->delete();
            foreach($request->trailers as $trailerData){
                
                $trailer = new DeliveryNoteTrailerInfo();
                $trailer->fill($trailerData);
                
                $deliveryNote->trailers()->save($trailer);
            }

            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Note updated successfully',
                'invoice' => $deliveryNote
            ], 201);



         }catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Note creation failed!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/user/delivery-note/{id}",
     *     tags={"Delivery Note"},
     *     summary="Delete Note",
     *     description="Delete note",
     *     operationId="deleteDeliveryNote",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the note",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invoice deleted successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Note deleted successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Note not found!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete note!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to delete note!")
     *         )
     *     )
     * )
     */
    public function deleteDeliveryNote($id)
    {
        $user = auth()->user();

        $note = DeliveryNote::where('user_id', $user->id)
            ->find($id);

        if (!$note) {
            return response()->json([
               'status'=>false,
                'message' => 'Note not found!'
            ], 404);
        }

        try {
            $note->delete();

            return response()->json([
                'status'=>true,
                'message' => 'Note deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
             return response()->json([
                'status'=>false,
                'message' => 'Server Error',
            ], 500);
        }
    }

     /** generate ubl xml using ubl v2.1 
     * @OA\Get(
     *    path="/user/delivery-note/ubl/{id}",
     *  tags={"Delivery Note"},
     * summary="Generate UBL XML",
     * description="Generate UBL XML",
     * operationId="generateDeliveryNoteUbl2.1",
     * @OA\Parameter(
     *   name="id",
     * in="path",
     * description="ID of the note",
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
     * description="Note not found!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolien", example="false"),
     * @OA\Property(property="message", type="string", example="Invoice not found!")
     * )
     * )
     * )
     */

    public function generateUbl($noteId)
    {
        $user = auth()->user();

        $note = DeliveryNote::where('user_id', $user->id)
            ->with('company', 'despatchType', 'currency', 'products')
            ->find($noteId);

        if (!$note) {
            return response()->json([
                'status' => false,
                'message' => 'Note not found!'
            ], 404);
        }

        $xmlService = new Service();
        $xmlService->namespaceMap = [
            'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2' => '',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
        ];

        $noteData = [
            'cbc:UBLVersionID' => '2.1',
            'cbc:CustomizationID' => 'TR1.2',
            'cbc:ProfileID' => 'TEMELFATURA',
            'cbc:ID' => $note->note_id,
            'cbc:CopyIndicator' => 'false',
            'cbc:UUID' => $note->invoice_uuid,
            'cbc:IssueDate' => $note->despatch_date,
            'cbc:IssueTime' => $note->shipment_time,
            'cbc:DespatchTypeCode' => $note->despatchType->name,
            'cbc:DocumentCurrencyCode' => $note->currency->code,
            'cac:AccountingSupplierParty' => [
                'cac:Party' => [
                    'cac:PartyIdentification' => [
                        ['cbc:ID' => $note->company->tax_number],
                        ['cbc:ID' => $note->company->gib_post_box],
                        ['cbc:ID' => $note->company->receiver_tapdk_number],
                    ],
                    'cac:PartyName' => [
                        'cbc:Name' => $note->company->company_name,
                    ],
                    'cac:PostalAddress' => [
                        'cbc:CityName' => $note->company->city,
                        'cbc:CountrySubentity' => $note->company->country,
                        'cbc:StreetName' => $note->company->address,
                    ],
                    'cac:PartyTaxScheme' => [
                        'cbc:CompanyID' => $note->company->tax_number,
                        'cbc:TaxOffice' => $note->company->tax_office,
                    ],
                    'cac:Contact' => [
                        'cbc:ElectronicMail' => $note->company->email,
                        'cbc:WebsiteURI' => $note->company->website,
                        'cbc:Telephone' => $note->company->phone_number,
                    ],
                ],
            ],
            'cac:AccountingCustomerParty' => [
                'cac:Party' => [
                    'cac:PartyIdentification' => [
                        ['cbc:ID' => $note->receiver_tax_number],
                        ['cbc:ID' => $note->receiver_gib_postacute],
                    ],
                    'cac:PartyName' => [
                        'cbc:Name' => $note->receiver_name,
                    ],
                    'cac:PostalAddress' => [
                        'cbc:CityName' => $note->receiver_city,
                        'cbc:CountrySubentity' => $note->receiver_country,
                        'cbc:StreetName' => $note->receiver_address,
                    ],
                    'cac:PartyTaxScheme' => [
                        'cbc:CompanyID' => $note->receiver_tax_number,
                        'cbc:TaxOffice' => $note->receiver_tax_office,
                    ],
                    'cac:Contact' => [
                        'cbc:ElectronicMail' => $note->receiver_mobile_number,
                    ],
                ],
            ],
            'cac:DespatchLine' => [
                'cbc:LineExtensionAmount' => $note->total_amount,
                'cbc:OrderReference' => [
                    'cbc:ID' => $note->order_number,
                    'cbc:IssueDate' => $note->order_date,
                ],
                // Add more despatch note fields here
            ],
        ];

        $noteLines = [];
        foreach ($note->products as $product) {
            $noteLines[] = [
                'cbc:ID' => $product->id,
                'cbc:InvoicedQuantity' => $product->quantity_one,
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
               
            ];
        }

        $noteData['cac:InvoiceLine'] = $noteLines;

        $outputXMLString = $xmlService->write('Invoice', $noteData);

        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'data' => $outputXMLString
        ]);
    }

}
