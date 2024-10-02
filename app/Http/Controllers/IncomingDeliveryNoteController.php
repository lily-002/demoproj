<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreIncomingDeliveryNoteRequestArchive;
use App\Http\Requests\StoreIncomingDeliveryNoteRequestCall;
use App\Http\Requests\StoreIncomingDeliveryNoteRequestIncoming;
use App\Http\Requests\UpdateIncomingDeliveryNoteRequestArchive;
use App\Http\Requests\UpdateIncomingDeliveryNoteRequestCall;
use App\Http\Requests\UpdateIncomingDeliveryNoteRequestIncoming;
use App\Models\IncomingDeliveryNoteArchive;
use App\Models\IncomingDeliveryNoteCall;
use App\Models\IncomingDeliveryNoteIncoming;

class IncomingDeliveryNoteController extends Controller
{
   
    /******
     * DELIVERY NOTE INCOMING METHODOS
     */
   
    /**
     * Get list of incoming delivery notes 
     * 
     * @OA\Get(
     *      path="/user/id-notes/incoming",
     *      tags={"Incoming Delivery Note"},
     *      summary="Get list of incoming delivery notes and paginate",
     *      description="Get list of incoming delivery notes associated with the authenticated user and paginate",
     *      operationId="getIncomingDeliveryNotesIncoming",
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery notes retrieved"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function getNotesIncoming($limit = 10)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        try{
            $incomingDeliveryNotes = IncomingDeliveryNoteIncoming::where('user_id', $user->id)->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery notes retrieved',
                'data' => $incomingDeliveryNotes
            ], 200);

        }catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500);
        }
    }

    /**
     * Create incoming delivery note
     * 
     * @OA\Post(
     *      path="/user/id-notes/incoming",
     *      tags={"Incoming Delivery Note"},
     *      summary="Create incoming delivery note",
     *      description="Create incoming delivery note",
     *      operationId="createIncomingDeliveryNoteIncoming",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="gib_dispatch_type", type="string", example="Basic - Dispatching"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="supplier_code", type="string", example="Sup21s"),
     *              @OA\Property(property="dispatch_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="dispatch_id", type="string", example="ARI2023000000218"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="dispatch_uuid", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="wild_card1", type="string", example="wild card"),
     *              @OA\Property(property="erp_reference", type="string", example="erp reference"),
     *              @OA\Property(property="order_number", type="string", example="order number"),
     *              @OA\Property(property="activity_envelope", type="string", example="activity envelope"),
     *              @OA\Property(property="package_info", type="string", example="package info"),
     *              @OA\Property(property="recieved_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="response_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note created"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function createNoteIncoming(StoreIncomingDeliveryNoteRequestIncoming $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        
        // Add user_id and company_id to the request data.
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;




        try{

            $data = IncomingDeliveryNoteIncoming::create($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note created',
                'data' => $data
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error ".$e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Get incoming delivery note by ID
     * 
     * @OA\Get(
     *      path="/user/id-notes/incoming/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Get incoming delivery note by ID",
     *      description="Get incoming delivery note by ID",
     *      operationId="getIncomingDeliveryNoteByIdIncoming",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note retrieved"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function getNoteIncoming($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
        $incomingDeliveryNote = IncomingDeliveryNoteIncoming::where('user_id', $user->id)
            ->find($id);

        if (!$incomingDeliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }
        
        try {
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note retrieved',
                'data' => $incomingDeliveryNote
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500);
        }
    }

    /**
     * Update incoming delivery note by ID
     * 
     * @OA\Put(
     *      path="/user/id-notes/incoming/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Update incoming delivery note by ID",
     *      description="Update incoming delivery note by ID",
     *      operationId="updateIncomingDeliveryNoteIncoming",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="gib_dispatch_type", type="string", example="Basic - Dispatching"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="supplier_code", type="string", example="Sup21s"),
     *              @OA\Property(property="dispatch_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="dispatch_id", type="string", example="ARI2023000000218"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="dispatch_uuid", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="wild_card1", type="string", example="wild card"),
     *              @OA\Property(property="erp_reference", type="string", example="erp reference"),
     *              @OA\Property(property="order_number", type="string", example="order number"),
     *              @OA\Property(property="activity_envelope", type="string", example="activity envelope"),
     *              @OA\Property(property="package_info", type="string", example="package info"),
     *              @OA\Property(property="recieved_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="response_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note updated"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function updateNoteIncoming(UpdateIncomingDeliveryNoteRequestIncoming $request, $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
         $incomingDeliveryNote = IncomingDeliveryNoteIncoming::where('user_id', $user->id)
            ->find($id);

        if (!$incomingDeliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        try{
            $validatedData = $request->validated();
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;


            $data = $incomingDeliveryNote->update($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500); 
        }
    }

    /**
     * Delete incoming delivery note by ID
     * 
     * @OA\Delete(
     *      path="/user/id-notes/incoming/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Delete incoming delivery note by ID",
     *      description="Delete incoming delivery note by ID",
     *      operationId="deleteIncomingDeliveryNoteIncoming",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note deleted"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function deleteNoteIncoming($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        $incomingDeliveryNote = IncomingDeliveryNoteIncoming::where('user_id', $user->id)
            ->find($id);

        if (!$incomingDeliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }


        
        try {

            $incomingDeliveryNote->delete();
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Generate UBL XML for an incoming delivery note
     * 
     * @OA\Get(
     *      path="/user/id-notes/incoming/ubl/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Generate UBL XML for an incoming delivery note",
     *      description="Generate UBL XML by providing the delivery note ID",
     *      operationId="incomingDeliveryNoteUBLXmlIncoming",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the delivery note to generate XML for",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/xml",
     *              example="<?xml version='1.0' encoding='UTF-8'?>
     *                        <IncomingDeliveryNote xmlns='urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'>
     *                            <cbc:ID>{$deliveryNote->id}</cbc:ID>
     *                            <cbc:CompanyName>{$deliveryNote->company->company_name}</cbc:CompanyName>
     *                        </IncomingDeliveryNote>"
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Incoming delivery note not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      )
     * )
     */
    public function generateUblIncoming($id)
    {
       // Retrieve the currently authenticated user.
       $user = auth()->user();
         $deliveryNote = IncomingDeliveryNoteIncoming::where('user_id', $user->id)
         ->with('company')
              ->find($id);

        if (!$deliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        // Create the XML document
        $xml = new \SimpleXMLElement('<IncomingDeliveryNote></IncomingDeliveryNote>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $deliveryNote->id);
        $xml->addChild('cbc:CompanyName', $deliveryNote->company->company_name);

        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        
        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }

    /******
     * DELIVERY NOTE ARCHIVE METHODOS
     */
   
    /**
     * Get list of incoming delivery notes 
     * 
     * @OA\Get(
     *      path="/user/id-notes/archive",
     *      tags={"Incoming Delivery Note"},
     *      summary="Get list of incoming delivery notes and paginate",
     *      description="Get list of incoming delivery notes associated with the authenticated user and paginate",
     *      operationId="getIncomingDeliveryNotesArchive",
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery notes retrieved"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function getNotesArchive($limit = 10)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        try{
            $incomingDeliveryNotes = IncomingDeliveryNoteArchive::where('user_id', $user->id)->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery notes retrieved',
                'data' => $incomingDeliveryNotes
            ], 200);

        }catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500);
        }
    }

    /**
     * Create incoming delivery note
     * 
     * @OA\Post(
     *      path="/user/id-notes/archive",
     *      tags={"Incoming Delivery Note"},
     *      summary="Create incoming delivery note",
     *      description="Create incoming delivery note",
     *      operationId="createIncomingDeliveryNoteArchive",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *               @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="gib_dispatch_type", type="string", example="Basic - Dispatching"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="supplier_code", type="string", example="Sup21s"),
     *              @OA\Property(property="dispatch_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="dispatch_id", type="string", example="ARI2023000000218"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="dispatch_uuid", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="wild_card1", type="string", example="wild card"),
     *              @OA\Property(property="erp_reference", type="string", example="erp reference"),
     *              @OA\Property(property="order_number", type="string", example="order number"),
     *              @OA\Property(property="activity_envelope", type="string", example="activity envelope"),
     *              @OA\Property(property="package_info", type="string", example="package info"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note created"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function createNoteArchive(StoreIncomingDeliveryNoteRequestArchive $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
        
        // Add user_id and company_id to the request data.
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;


        try{

            $data = IncomingDeliveryNoteArchive::create($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note created',
                'data' => $data
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500); 
        }
    }

    /**
     * Get incoming delivery note by ID
     * 
     * @OA\Get(
     *      path="/user/id-notes/archive/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Get incoming delivery note by ID",
     *      description="Get incoming delivery note by ID",
     *      operationId="getIncomingDeliveryNoteByIdArchive",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note retrieved"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function getNoteArchive($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
        $incomingDeliveryNote = IncomingDeliveryNoteArchive::where('user_id', $user->id)
            ->find($id);

        if (!$incomingDeliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        try {
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note retrieved',
                'data' => $incomingDeliveryNote
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500);
        }
    }

    /**
     * Update incoming delivery note by ID
     * 
     * @OA\Put(
     *      path="/user/id-notes/archive/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Update incoming delivery note by ID",
     *      description="Update incoming delivery note by ID",
     *      operationId="updateIncomingDeliveryNoteArchive",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="gib_dispatch_type", type="string", example="Basic - Dispatching"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="supplier_code", type="string", example="Sup21s"),
     *              @OA\Property(property="dispatch_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="dispatch_id", type="string", example="ARI2023000000218"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="dispatch_uuid", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="wild_card1", type="string", example="wild card"),
     *              @OA\Property(property="erp_reference", type="string", example="erp reference"),
     *              @OA\Property(property="order_number", type="string", example="order number"),
     *              @OA\Property(property="activity_envelope", type="string", example="activity envelope"),
     *              @OA\Property(property="package_info", type="string", example="package info"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note updated"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function updateNoteArchive(UpdateIncomingDeliveryNoteRequestArchive $request,  $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
            $incomingDeliveryNote = IncomingDeliveryNoteArchive::where('user_id', $user->id)
                ->find($id);

        if (!$incomingDeliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }   
        try{
            $validatedData = $request->validated();
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

            $data = $incomingDeliveryNote->update($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500); 
        }
    }

    /**
     * Delete incoming delivery note by ID
     * 
     * @OA\Delete(
     *      path="/user/id-notes/archive/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Delete incoming delivery note by ID",
     *      description="Delete incoming delivery note by ID",
     *      operationId="deleteIncomingDeliveryNoteArchive",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note deleted"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function deleteNoteArchive($id)
    {
       
        $user = auth()->user();
        $incomingDeliveryNote = IncomingDeliveryNoteArchive::where('user_id', $user->id)
            ->find($id);
        
        if (!$incomingDeliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        
        try {

            $incomingDeliveryNote->delete();
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Generate UBL XML for an incoming delivery note
     * 
     * @OA\Get(
     *      path="/user/id-notes/archive/ubl/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Generate UBL XML for an incoming delivery note",
     *      description="Generate UBL XML by providing the delivery note ID",
     *      operationId="incomingDeliveryNoteUBLXmlArchive",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the delivery note to generate XML for",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/xml",
     *              example="<?xml version='1.0' encoding='UTF-8'?>
     *                        <IncomingDeliveryNote xmlns='urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'>
     *                            <cbc:ID>{$deliveryNote->id}</cbc:ID>
     *                            <cbc:CompanyName>{$deliveryNote->company->company_name}</cbc:CompanyName>
     *                        </IncomingDeliveryNote>"
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Incoming delivery note not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      )
     * )
     */
    public function generateUblArchive($id)
    {
       // Retrieve the currently authenticated user.
       $user = auth()->user();
       $deliveryNote = IncomingDeliveryNoteArchive::where('user_id', $user->id)
            ->with('company')
            ->find($id);

        if (!$deliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }


        // Create the XML document
        $xml = new \SimpleXMLElement('<IncomingDeliveryNote></IncomingDeliveryNote>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $deliveryNote->id);
        $xml->addChild('cbc:CompanyName', $deliveryNote->company->company_name);

        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        
        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }

    /******
     * DELIVERY NOTE CALL METHODOS
     */

    /**
     * Get list of incoming delivery notes 
     * 
     * @OA\Get(
     *      path="/user/id-notes/call",
     *      tags={"Incoming Delivery Note"},
     *      summary="Get list of incoming delivery notes and paginate",
     *      description="Get list of incoming delivery notes associated with the authenticated user and paginate",
     *      operationId="getIncomingDeliveryNotesCalls",
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery notes retrieved"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function getNotesCall($limit = 10)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        try{
            $incomingDeliveryNotes = IncomingDeliveryNoteCall::where('user_id', $user->id)->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery notes retrieved',
                'data' => $incomingDeliveryNotes
            ], 200);

        }catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500);
        }
    }

    /**
     * Create incoming delivery note
     * 
     * @OA\Post(
     *      path="/user/id-notes/call",
     *      tags={"Incoming Delivery Note"},
     *      summary="Create incoming delivery note",
     *      description="Create incoming delivery note",
     *      operationId="createIncomingDeliveryNoteCall",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             @OA\Property(property="buyer_company", type="string", example="Company Name"),
     *             @OA\Property(property="buyer_company_vkn", type="string", example="2833264524"),
     *             @OA\Property(property="receipient_company_mailbox", type="string", example="625sdfg"),
     *             @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="gib_dispatch_type", type="string", example="Basic - Dispatching"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="supplier_code", type="string", example="Sup21s"),
     *              @OA\Property(property="dispatch_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="dispatch_id", type="string", example="ARI2023000000218"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="dispatch_uuid", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="wild_card1", type="string", example="wild card"),
     *              @OA\Property(property="erp_reference", type="string", example="erp reference"),
     *              @OA\Property(property="order_number", type="string", example="order number"),
     *              @OA\Property(property="activity_envelope", type="string", example="activity envelope"),
     *              @OA\Property(property="package_info", type="string", example="package info"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="last_update_user", type="string", example="last_update_user"),
     *              @OA\Property(property="is_active", type="boolean", example=true),
     *              @OA\Property(property="is_archive", type="boolean", example=true),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note created"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function createNoteCall(StoreIncomingDeliveryNoteRequestCall $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
        
        // Add user_id and company_id to the request data.
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

        try{

            $data = IncomingDeliveryNoteCall::create($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note created',
                'data' => $data
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500); 
        }
    }

    /**
     * Get incoming delivery note by ID
     * 
     * @OA\Get(
     *      path="/user/id-notes/call/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Get incoming delivery note by ID",
     *      description="Get incoming delivery note by ID",
     *      operationId="getIncomingDeliveryNoteByIdCall",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note retrieved"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function getNoteCall($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        $incomingDeliveryNote = IncomingDeliveryNoteCall::where('user_id', $user->id)
            ->find($id);

            if (!$incomingDeliveryNote) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not found'
                ], 404);
            }

        
        try {
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note retrieved',
                'data' => $incomingDeliveryNote
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500);
        }
    }

    /**
     * Update incoming delivery note by ID
     * 
     * @OA\Put(
     *      path="/user/id-notes/call/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Update incoming delivery note by ID",
     *      description="Update incoming delivery note by ID",
     *      operationId="updateIncomingDeliveryNoteCall",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             @OA\Property(property="buyer_company", type="string", example="Company Name"),
     *             @OA\Property(property="buyer_company_vkn", type="string", example="2833264524"),
     *             @OA\Property(property="receipient_company_mailbox", type="string", example="625sdfg"),
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="gib_dispatch_type", type="string", example="Basic - Dispatching"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="supplier_code", type="string", example="Sup21s"),
     *              @OA\Property(property="dispatch_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="dispatch_id", type="string", example="ARI2023000000218"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="dispatch_uuid", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="wild_card1", type="string", example="wild card"),
     *              @OA\Property(property="erp_reference", type="string", example="erp reference"),
     *              @OA\Property(property="order_number", type="string", example="order number"),
     *              @OA\Property(property="activity_envelope", type="string", example="activity envelope"),
     *              @OA\Property(property="package_info", type="string", example="package info"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="last_update_user", type="string", example="last_update_user"),
     *              @OA\Property(property="is_active", type="boolean", example=true),
     *              @OA\Property(property="is_archive", type="boolean", example=true),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note updated"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function updateNoteCall(UpdateIncomingDeliveryNoteRequestCall $request, $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
        $incomingDeliveryNote = IncomingDeliveryNoteCall::where('user_id', $user->id)
            ->find($id);

        if (!$incomingDeliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        try{
            $validatedData = $request->validated();
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

            $data = $incomingDeliveryNote->update($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error",
            ], 500); 
        }
    }

    /**
     * Delete incoming delivery note by ID
     * 
     * @OA\Delete(
     *      path="/user/id-notes/call/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Delete incoming delivery note by ID",
     *      description="Delete incoming delivery note by ID",
     *      operationId="deleteIncomingDeliveryNoteCall",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Incoming delivery note ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Incoming delivery note deleted"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     */
    public function deleteNoteCall($id)
    {
        // Retrieve the currently authenticated user.
       $user = auth()->user();
         $incomingDeliveryNote = IncomingDeliveryNoteCall::where('user_id', $user->id)
                ->find($id);
          
          if (!$incomingDeliveryNote) {
                return response()->json([
                 'status' => false,
                 'message' => 'Not found'
                ], 404);
          }
       
        try {

            $incomingDeliveryNote->delete();
            return response()->json([
                'status' => true,
                'message' => 'Incoming delivery note deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

   /**
     * Generate UBL XML for an incoming delivery note
     * 
     * @OA\Get(
     *      path="/user/id-notes/call/ubl/{id}",
     *      tags={"Incoming Delivery Note"},
     *      summary="Generate UBL XML for an incoming delivery note",
     *      description="Generate UBL XML by providing the delivery note ID",
     *      operationId="incomingDeliveryNoteUBLXmlCall",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the delivery note to generate XML for",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/xml",
     *              example="<?xml version='1.0' encoding='UTF-8'?>
     *                        <IncomingDeliveryNote xmlns='urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'>
     *                            <cbc:ID>{$deliveryNote->id}</cbc:ID>
     *                            <cbc:CompanyName>{$deliveryNote->company->company_name}</cbc:CompanyName>
     *                        </IncomingDeliveryNote>"
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Incoming delivery note not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      )
     * )
     */
    public function generateUblCall($id)
    {
       // Retrieve the currently authenticated user.
       $user = auth()->user();
         $deliveryNote = IncomingDeliveryNoteCall::where('user_id', $user->id)
                ->with('company')
                ->find($id);


        if (!$deliveryNote) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        // Create the XML document
        $xml = new \SimpleXMLElement('<IncomingDeliveryNote></IncomingDeliveryNote>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $deliveryNote->id);
        $xml->addChild('cbc:CompanyName', $deliveryNote->company->company_name);

        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        
        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }

    
}