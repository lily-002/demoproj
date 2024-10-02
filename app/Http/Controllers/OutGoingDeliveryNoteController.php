<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutgoingDeliveryNoteRequestArchive;
use App\Http\Requests\StoreOutgoingDeliveryNoteRequestCall;
use App\Http\Requests\StoreOutgoingDeliveryNoteRequestCancellation;
use App\Http\Requests\StoreOutgoingDeliveryNoteRequestOutgoing;
use App\Http\Requests\UpdateOutgoingDeliveryNoteRequestArchive;
use App\Http\Requests\UpdateOutgoingDeliveryNoteRequestCall;
use App\Http\Requests\UpdateOutgoingDeliveryNoteRequestCancellation;
use App\Http\Requests\UpdateOutgoingDeliveryNoteRequestOutgoing;
use App\Models\OutGoingDeliveryNoteArchive;
use App\Models\OutGoingDeliveryNoteCall;
use App\Models\OutGoingDeliveryNoteCancellation;
use App\Models\OutGoingDeliveryNoteOutgoing;

class OutGoingDeliveryNoteController extends Controller
{
   
    /**
     * OUTGOING DELIVERY NOTE - OUTGOING
     */
   
    /**
     * @OA\Get(
     *     path="/user/od-note/outgoing",
     *     tags={"Outgoing Delivery Note"},
     *     summary="Get Outgoing Delivery Notes",
     *     description="Get Outgoing Delivery Notes",
     *     operationId="getODNotesOutgoing",
     *     @OA\Response(
     *         response=200,
     *         description="Outgoing Delivery Notes fetched successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Outgoing Delivery Notes fetched successfully!"),
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
    public function getODNotesOutgoing($limit=10)
    {
        // Get the authenticated user
        $user = auth()->user();

        try {
            $notes = OutGoingDeliveryNoteOutgoing::where('user_id', $user->id)
                ->paginate($limit);

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Notes fetched successfully!',
                'data' => $notes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!',
            ], 500);
        }
        
      
    }

     /**
     * @OA\Get(
     *    path="/user/od-note/outgoing/{id}",
     *   tags={"Outgoing Delivery Note"},
     *  summary="Get Outgoing Delivery Note",
     * description="Get Outgoing Delivery Note",
     * operationId="getODNoteOutgoing",
     * @OA\Parameter(
     *    name="id",
     *  in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note retrieved successfully"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     *  response=404,
     * description="Outgoing delivery note not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note not found")
     * )
     * )
     * )
     */
    public function getODNoteOutgoing($id)
    {
         // Get the authenticated user
        $user = auth()->user();

        try {
            $note = OutGoingDeliveryNoteOutgoing::where('user_id', $user->id)
                ->find($id);

            if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not found'
                ], 404);
            }   

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Note fetched successfully!',
                'data' => $note
            ], 200);

            if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => 'Outgoing delivery note not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!',
            ], 500);
        }
    }

    /**
     * Create outgoing delivery note
     * @OA\Post(
     *    path="/user/od-note/outgoing",
     *   tags={"Outgoing Delivery Note"},
     * summary="Create outgoing delivery note",
     * description="Create outgoing delivery note",
     * operationId="createODNotesOutgoing",
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="activity_envelope", type="string", example="activity_envelope"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="mail_delivery_status", type="string", example="mail_delivery_status"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="last_update_user", type="string", example="last_update_user"),
     * @OA\Property(property="company_id", type="string", example="1"),
     * 
     *
     * ),
     * ),
     * @OA\Response(
     *  response=201,
     * description="Success",
     * @OA\JsonContent(
     *   @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note created successfully"),
     * ),
     * ),
     * )
     * 
     * 
     */
   public function createODNoteOutgoing(StoreOutgoingDeliveryNoteRequestOutgoing $request)
    {


        try {
            // Get the authenticated user
            $user = auth()->user();

            
            // Add user_id and company_id to the request data.
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user->id;
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;


            

            
            // Create OutGoingDeliveryNote with only validated attributes
            $note = OutGoingDeliveryNoteOutgoing::create($validatedData);
        
            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note created successfully',
                'data' => $note
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not created, an error occurred"
            ], 500);
        }
    }


    /**
     * Update outgoing delivery note
     * @OA\Put(
     *    path="/user/od-note/outgoing/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Update outgoing delivery note",
     * description="Update outgoing delivery note",
     * operationId="updateODNoteOutgoing",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="activity_envelope", type="string", example="activity_envelope"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="mail_delivery_status", type="string", example="mail_delivery_status"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="last_update_user", type="string", example="last_update_user"),
    *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note updated successfully"),
     * ),
     * ),
     * )
     */
    public function updateODNoteOutgoing(UpdateOutgoingDeliveryNoteRequestOutgoing $request, $id)
    {
        // Get the authenticated user
        $user = auth()->user();
        $outgoingDeliveryNote = OutGoingDeliveryNoteOutgoing::where('user_id', $user->id)->
         find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }

        $validatedData = $request->validated();
        $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

      
        try {
          
            $data = $outgoingDeliveryNote->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note updated successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not updated, an error occurred"
            ], 500);
        
        }

    }

    /**
     * Delete outgoing delivery note
     * @OA\Delete(
     *    path="/user/od-note/outgoing/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Delete outgoing delivery note",
     * description="Delete outgoing delivery note",
     * operationId="deleteODNoteOutgoing",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note deleted successfully"),
     * ),
     * ),
     * )
     */
    public function deleteODNoteOutgoing($id)
    {
        $user = auth()->user();
        
        $outgoingDeliveryNote = OutGoingDeliveryNoteOutgoing::where('user_id', $user->id)->
        find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }


        try {

            if ($outgoingDeliveryNote->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Outgoing delivery note deleted successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not deleted'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not deleted, an error occurred",
            ], 500);
        
        }
    }

     /** generate ubl xml using ubl v2.1 
     * @OA\Get(
     *    path="/user/od-note/ubl/{id}",
     *  tags={"Outgoing Delivery Note"},
     * summary="Generate UBL XML",
     * description="Generate UBL XML",
     * operationId="generateODNoteUbl",
     * @OA\Parameter(
     *   name="id",
     * in="path",
     * description="ID of the od noted",
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
     * description="Invoice not found!",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolien", example="false"),
     * @OA\Property(property="message", type="string", example="Note not found!")
     * )
     * )
     * )
     */
    public function generateUblXml($id)
    {
        $user = auth()->user();

        $note = OutGoingDeliveryNoteOutgoing::where('user_id', $user->id)->with('company')
            ->find($id);
        
        

        if (!$note) {
            return response()->json([
                'status' => false,
                'message' => 'Note not found'
            ], 404);
        }

        // Create the XML document
        $xml = new \SimpleXMLElement('<OutgoingDeliveryNote></OutgoingDeliveryNote>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $note->id);
        $xml->addChild('cbc:CompanyName', $note->company->company_name);


        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        


        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }

    /**
     * OUTGOING DELIVERY NOTE - ARCHIVE
     */
   
    /**
     * @OA\Get(
     *     path="/user/od-note/archive",
     *     tags={"Outgoing Delivery Note"},
     *     summary="Get Outgoing Delivery Notes",
     *     description="Get Outgoing Delivery Notes",
     *     operationId="getODNotesArchive",
     *     @OA\Response(
     *         response=200,
     *         description="Outgoing Delivery Notes fetched successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Outgoing Delivery Notes fetched successfully!"),
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
    public function getODNotesArchive($limit=10)
    {
        // Get the authenticated user
        $user = auth()->user();

        try {
            $notes = OutGoingDeliveryNoteArchive::where('user_id', $user->id)
                ->paginate($limit);

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Notes fetched successfully!',
                'data' => $notes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!'
            ], 500);
        }
        
      
    }

     /**
     * @OA\Get(
     *    path="/user/od-note/archive/{id}",
     *   tags={"Outgoing Delivery Note"},
     *  summary="Get Outgoing Delivery Note",
     * description="Get Outgoing Delivery Note",
     * operationId="getODNoteArchive",
     * @OA\Parameter(
     *    name="id",
     *  in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note retrieved successfully"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     *  response=404,
     * description="Outgoing delivery note not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note not found")
     * )
     * )
     * )
     */
    public function getODNoteArchive($id)
    {
         // Get the authenticated user
        $user = auth()->user();

        try {
            $note = OutGoingDeliveryNoteArchive::where('user_id', $user->id)
                ->find($id);

                if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not found'
                ], 404);
            }   

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Note fetched successfully!',
                'data' => $note
            ], 200);

            if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => 'Outgoing delivery note not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!',
            ], 500);
        }
    }

    /**
     * Create outgoing delivery note
     * @OA\Post(
     *    path="/user/od-note/archive",
     *   tags={"Outgoing Delivery Note"},
     * summary="Create outgoing delivery note",
     * description="Create outgoing delivery note",
     * operationId="createODNotesArchive",
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="activity_envelope", type="string", example="activity_envelope"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="connector_status", type="string", example="connector_status"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *
     * ),
     * ),
     * @OA\Response(
     *  response=201,
     * description="Success",
     * @OA\JsonContent(
     *   @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note created successfully"),
     * ),
     * ),
     * )
     * 
     * 
     */
   public function createODNoteArchive(StoreOutgoingDeliveryNoteRequestArchive $request)
    {


        try {
            // Get the authenticated user
            $user = auth()->user();
            
            // Add user_id and company_id to the request data.
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user->id;
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

            
            // Create OutGoingDeliveryNote with only validated attributes
            $note = OutGoingDeliveryNoteArchive::create($validatedData);
        
            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note created successfully',
                'data' => $note
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not created, an error occurred"
            ], 500);
        }
    }


    /**
     * Update outgoing delivery note
     * @OA\Put(
     *    path="/user/od-note/archive/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Update outgoing delivery note",
     * description="Update outgoing delivery note",
     * operationId="updateODNoteArchive",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="activity_envelope", type="string", example="activity_envelope"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="connector_status", type="string", example="connector_status"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note updated successfully"),
     * ),
     * ),
     * )
     */
    public function updateODNoteArchive(UpdateOutgoingDeliveryNoteRequestArchive $request, $id)
    {
        // Get the authenticated user
        $user = auth()->user();
        $outgoingDeliveryNote = OutGoingDeliveryNoteArchive::where('user_id', $user->id)->
         find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }

      
        try {

            $validatedData = $request->validated();
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;
          
            $data = $outgoingDeliveryNote->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note updated successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not updated, an error occurred"
            ], 500);
        
        }

    }

    /**
     * Delete outgoing delivery note
     * @OA\Delete(
     *    path="/user/od-note/archive/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Delete outgoing delivery note",
     * description="Delete outgoing delivery note",
     * operationId="deleteODNoteArchive",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note deleted successfully"),
     * ),
     * ),
     * )
     */
    public function deleteODNoteArchive($id)
    {
        $user = auth()->user();
        
        $outgoingDeliveryNote = OutGoingDeliveryNoteArchive::where('user_id', $user->id)->
        find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }


        try {

            if ($outgoingDeliveryNote->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Outgoing delivery note deleted successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not deleted'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not deleted, an error occurred",
            ], 500);
        
        }
    }

    /**
     * OUTGOING DELIVERY NOTE - Cancellation
     */
   
    /**
     * @OA\Get(
     *     path="/user/od-note/cancellation",
     *     tags={"Outgoing Delivery Note"},
     *     summary="Get Outgoing Delivery Notes",
     *     description="Get Outgoing Delivery Notes",
     *     operationId="getODNotesCancellation",
     *     @OA\Response(
     *         response=200,
     *         description="Outgoing Delivery Notes fetched successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Outgoing Delivery Notes fetched successfully!"),
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
    public function getODNotesCancellation($limit=10)
    {
        // Get the authenticated user
        $user = auth()->user();

        try {
            $notes = OutGoingDeliveryNoteCancellation::where('user_id', $user->id)
                ->paginate($limit);

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Notes fetched successfully!',
                'data' => $notes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!',
            ], 500);
        }
        
      
    }

     /**
     * @OA\Get(
     *    path="/user/od-note/cancellation/{id}",
     *   tags={"Outgoing Delivery Note"},
     *  summary="Get Outgoing Delivery Note",
     * description="Get Outgoing Delivery Note",
     * operationId="getODNoteCancellation",
     * @OA\Parameter(
     *    name="id",
     *  in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note retrieved successfully"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     *  response=404,
     * description="Outgoing delivery note not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note not found")
     * )
     * )
     * )
     */
    public function getODNoteCancellation($id)
    {
         // Get the authenticated user
        $user = auth()->user();

        try {
            $note = OutGoingDeliveryNoteCancellation::where('user_id', $user->id)
                ->find($id);

                if (!$note) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Not found'
                    ], 404);
                }   

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Note fetched successfully!',
                'data' => $note
            ], 200);

            if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => 'Outgoing delivery note not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!',
            ], 500);
        }
    }

    /**
     * Create outgoing delivery note
     * @OA\Post(
     *    path="/user/od-note/cancellation",
     *   tags={"Outgoing Delivery Note"},
     * summary="Create outgoing delivery note",
     * description="Create outgoing delivery note",
     * operationId="createODNotesCancellation",
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="activity_envelope", type="string", example="activity_envelope"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="connector_status", type="string", example="connector_status"),
     * @OA\Property(property="cancellation_time", type="string", example="2022-03-12"),
     * @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *
     * ),
     * ),
     * @OA\Response(
     *  response=201,
     * description="Success",
     * @OA\JsonContent(
     *   @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note created successfully"),
     * ),
     * ),
     * )
     * 
     * 
     */
   public function createODNoteCancellation(StoreOutgoingDeliveryNoteRequestCancellation $request)
    {


        try {
            // Get the authenticated user
            $user = auth()->user();
            
            // Add user_id and company_id to the request data.
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user->id;
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

            
            // Create OutGoingDeliveryNote with only validated attributes
            $note = OutGoingDeliveryNoteCancellation::create($validatedData);
        
            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note created successfully',
                'data' => $note
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not created, an error occurred"
            ], 500);
        }
    }


    /**
     * Update outgoing delivery note
     * @OA\Put(
     *    path="/user/od-note/cancellation/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Update outgoing delivery note",
     * description="Update outgoing delivery note",
     * operationId="updateODNoteCancellation",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="activity_envelope", type="string", example="activity_envelope"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="connector_status", type="string", example="connector_status"),
     * @OA\Property(property="cancellation_time", type="string", example="2022-03-12"),
     * @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note updated successfully"),
     * ),
     * ),
     * )
     */
    public function updateODNoteCancellation(UpdateOutgoingDeliveryNoteRequestCancellation $request, $id)
    {
        // Get the authenticated user
        $user = auth()->user();
        $outgoingDeliveryNote = OutGoingDeliveryNoteCancellation::where('user_id', $user->id)->
         find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }

      
        try {

            $validatedData = $request->validated();
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;



          
            $data = $outgoingDeliveryNote->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note updated successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not updated, an error occurred"
            ], 500);
        
        }

    }

    /**
     * Delete outgoing delivery note
     * @OA\Delete(
     *    path="/user/od-note/cancellation/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Delete outgoing delivery note",
     * description="Delete outgoing delivery note",
     * operationId="deleteODNoteCancellation",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note deleted successfully"),
     * ),
     * ),
     * )
     */
    public function deleteODNoteCancellation($id)
    {
        $user = auth()->user();
        
        $outgoingDeliveryNote = OutGoingDeliveryNoteCancellation::where('user_id', $user->id)->
        find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }


        try {

            if ($outgoingDeliveryNote->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Outgoing delivery note deleted successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not deleted'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not deleted, an error occurred",
            ], 500);
        
        }
    }

    /**
     * OUTGOING DELIVERY NOTE - Call
     */
   
    /**
     * @OA\Get(
     *     path="/user/od-note/call",
     *     tags={"Outgoing Delivery Note"},
     *     summary="Get Outgoing Delivery Notes",
     *     description="Get Outgoing Delivery Notes",
     *     operationId="getODNotesCall",
     *     @OA\Response(
     *         response=200,
     *         description="Outgoing Delivery Notes fetched successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Outgoing Delivery Notes fetched successfully!"),
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
    public function getODNotesCall($limit=10)
    {
        // Get the authenticated user
        $user = auth()->user();

        try {
            $notes = OutGoingDeliveryNoteCall::where('user_id', $user->id)
                ->paginate($limit);

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Notes fetched successfully!',
                'data' => $notes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!',
            ], 500);
        }
        
      
    }

     /**
     * @OA\Get(
     *    path="/user/od-note/call/{id}",
     *   tags={"Outgoing Delivery Note"},
     *  summary="Get Outgoing Delivery Note",
     * description="Get Outgoing Delivery Note",
     * operationId="getODNoteCall",
     * @OA\Parameter(
     *    name="id",
     *  in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note retrieved successfully"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     *  response=404,
     * description="Outgoing delivery note not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note not found")
     * )
     * )
     * )
     */
    public function getODNoteCall($id)
    {
         // Get the authenticated user
        $user = auth()->user();

        try {
            $note = OutGoingDeliveryNoteCall::where('user_id', $user->id)
                ->find($id);
                
                if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not found'
                ], 404);
                }   

            return response()->json([
                'status'=>true,
                'message' => 'Outgoing Delivery Note fetched successfully!',
                'data' => $note
            ], 200);

            if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => 'Outgoing delivery note not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch notes!',
            ], 500);
        }
    }

    /**
     * Create outgoing delivery note
     * @OA\Post(
     *    path="/user/od-note/call",
     *   tags={"Outgoing Delivery Note"},
     * summary="Create outgoing delivery note",
     * description="Create outgoing delivery note",
     * operationId="createODNotesCall",
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="sender_company", type="string", example="Sender Company"),
     * @OA\Property(property="sender_company_vkn", type="string", example="1234567890"),
     * @OA\Property(property="sender_company_mailbox", type="email", example="sender_company@email.com"),
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="mail_delivery_status", type="string", example="mail_delivery_status"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="connector_status", type="string", example="portal_status"),
     * @OA\Property(property="cancel_status", type="string", example="cancel_status"),
     * @OA\Property(property="is_archive", type="boolean"),
     * @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *
     * ),
     * ),
     * @OA\Response(
     *  response=201,
     * description="Success",
     * @OA\JsonContent(
     *   @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note created successfully"),
     * ),
     * ),
     * )
     * 
     * 
     */
   public function createODNoteCall(StoreOutgoingDeliveryNoteRequestCall $request)
    {


        try {
            // Get the authenticated user
            $user = auth()->user();
            
            // Add user_id and company_id to the request data.
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user->id;
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

            
            // Create OutGoingDeliveryNote with only validated attributes
            $note = OutGoingDeliveryNoteCall::create($validatedData);
        
            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note created successfully',
                'data' => $note
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not created, an error occurred"
            ], 500);
        }
    }


    /**
     * Update outgoing delivery note
     * @OA\Put(
     *    path="/user/od-note/call/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Update outgoing delivery note",
     * description="Update outgoing delivery note",
     * operationId="updateODNoteCall",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * @OA\Property(property="sender_company", type="string", example="Sender Company"),
     * @OA\Property(property="sender_company_vkn", type="string", example="1234567890"),
     * @OA\Property(property="sender_company_mailbox", type="email", example="sender_company@email.com"),
     * @OA\Property(property="customer_name", type="string", example="John Doe"),
     * @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     * @OA\Property(property="gib_dispatch_type", type="string", example="gib_dispatch_type"),
     * @OA\Property(property="gib_dispatch_send_type", type="string", example="gib_dispatch_send_type"),
     * @OA\Property(property="supplier_code", type="string", example="supplier_code"),
     * @OA\Property(property="dispatch_date", type="date", example="2022-03-12"),
     * @OA\Property(property="dispatch_id", type="string", example="dispatch_id"),
     * @OA\Property(property="amount", type="number", example="100.00"),
     * @OA\Property(property="status", type="string", example="pending"),
     * @OA\Property(property="dispatch_uuid", type="string", example="dispatch_uuid"),
     * @OA\Property(property="gib_post_box_email", type="string", example="gib_post_box_email"),
     * @OA\Property(property="wild_card1", type="string", example="wild_card1"),
     * @OA\Property(property="erp_reference", type="string", example="erp_reference"),
     * @OA\Property(property="order_number", type="string", example="order_number"),
     * @OA\Property(property="package_info", type="string", example="package_info"),
     * @OA\Property(property="send_date", type="date", example="2022-03-12"),
     * @OA\Property(property="received_date", type="date", example="2022-03-12"),
     * @OA\Property(property="response_date", type="date", example="2022-03-12"),
     * @OA\Property(property="mail_delivery_status", type="string", example="mail_delivery_status"),
     * @OA\Property(property="portal_status", type="string", example="portal_status"),
     * @OA\Property(property="connector_status", type="string", example="portal_status"),
     * @OA\Property(property="cancel_status", type="string", example="cancel_status"),
     * @OA\Property(property="is_archive", type="boolean"),
     * @OA\Property(property="last_update_user", type="string", example="last_update_user"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note updated successfully"),
     * ),
     * ),
     * )
     */
    public function updateODNoteCall(UpdateOutgoingDeliveryNoteRequestCall $request, $id)
    {
        // Get the authenticated user
        $user = auth()->user();
        $outgoingDeliveryNote = OutGoingDeliveryNoteCall::where('user_id', $user->id)->
         find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }
      
        try {
            
            $validatedData = $request->validated();
            $validatedData['company_id'] = $user->hasRole('admin') ? $validatedData['company_id'] : $user->company_id;

            $data = $outgoingDeliveryNote->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Outgoing delivery note updated successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not updated, an error occurred"
            ], 500);
        
        }

    }

    /**
     * Delete outgoing delivery note
     * @OA\Delete(
     *    path="/user/od-note/call/{id}",
     *   tags={"Outgoing Delivery Note"},
     * summary="Delete outgoing delivery note",
     * description="Delete outgoing delivery note",
     * operationId="deleteODNoteCall",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="Outgoing delivery note id",
     * required=true,
     * @OA\Schema(
     *   type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Outgoing delivery note deleted successfully"),
     * ),
     * ),
     * )
     */
    public function deleteODNoteCall($id)
    {
        $user = auth()->user();
        
        $outgoingDeliveryNote = OutGoingDeliveryNoteCall::where('user_id', $user->id)->
        find($id);
        if (!$outgoingDeliveryNote) {
            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not found'
            ], 404);
        }


        try {

            if ($outgoingDeliveryNote->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Outgoing delivery note deleted successfully'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Outgoing delivery note not deleted'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Outgoing delivery note not deleted, an error occurred",
            ], 500);
        
        }
    }
}