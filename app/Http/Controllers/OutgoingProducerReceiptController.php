<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProducerReceiptArchiveRequest;
use App\Http\Requests\StoreProducerReceiptCallRequest;
use App\Http\Requests\StoreProducerReceiptCancellationRequest;
use App\Http\Requests\StoreProducerReceiptOutgoingRequest;
use App\Http\Requests\UpdateProducerReceiptArchiveRequest;
use App\Http\Requests\UpdateProducerReceiptCallRequest;
use App\Http\Requests\UpdateProducerReceiptCancellationRequest;
use App\Http\Requests\UpdateProducerReceiptOutgoingRequest;
use App\Models\ProducerReceiptArchive;
use App\Models\ProducerReceiptCall;
use App\Models\ProducerReceiptCancellation;
use App\Models\ProducerReceiptOutgoing;

class OutgoingProducerReceiptController extends Controller
{
    // METHODS FOR PRODUCER RECEIPT (ARCHIVE)

    /**
     * Get producer receipt (archive) list by company id 
     * 
     * @OA\Get(
     *      path="/user/producer-receipts/archives",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get list of producer receipt (archives) and paginate",
     *      description="Get list of producer receipt (archives) associated with the authenticated user and paginate",
     *      operationId="producerReceiptArchives",
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipts retrieved"),
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
    public function indexArchives($limit = 10)
    {
         // Retrieve the currently authenticated user.
         $user = auth()->user();

         try{

            $receipts = ProducerReceiptArchive::where('user_id', $user->id)->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipts retrieved',
                'data' => $receipts
            ], 200);
 
         }catch(\Exception $e){
 
             return response()->json([
                 'status' => false,
                 'message' => "Internal server error: " . $e->getMessage(),
             ], 500);
         }
    }

    /**
     * Create producer receipt (archives)
     * 
     * @OA\Post(
     *      path="/user/producer-receipts/archives",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Create producer receipt (arcives)",
     *      description="Create producer receipt (arcives)",
     *      operationId="createProducerReceiptArcives",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                  "customer_name",
     *                  "customer_tax_number",
     *                  "producer_receipt_date",
     *                  "producer_receipt_no",
     *                  "ettn",
     *                  "amount",
     *                  "status",
     *                  "gib_post_box_email",
     *                  "portal_status",
     *                  "connector_status",
     *                  "company_id",
     *                  "user_id",
     *              },
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="producer_receipt_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="producer_receipt_no", type="string", example="EMM2022000000006"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="company email"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt created"),
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
    public function storeArchives(StoreProducerReceiptArchiveRequest $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        try{

            $receipt = $request->validated();
            $receipt['company_id'] = $user->hasRole('admin') ? $receipt['company_id'] : $user->company_id;
            $receipt['user_id'] = $user->id;

            ProducerReceiptArchive::create($receipt);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt created',
                'data' => $receipt
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Get producer receipt (archives) by ID
     * 
     * @OA\Get(
     *      path="/user/producer-receipts/archives/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get producer receipt (archives) by ID",
     *      description="Get producer receipt (archives) by ID",
     *      operationId="getProducerReceiptArchivesById",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (archives) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt retrieved"),
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
    public function showArchives($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        
        try {

            $receipt = ProducerReceiptArchive::where('user_id', $user->id)->find($id);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipt retrieved',
                'data' => $receipt
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update producer receipt (archives) by ID
     * 
     * @OA\Put(
     *      path="/user/producer-receipts/archives/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Update producer receipt (archives) by ID",
     *      description="Update producer receipt (archives) by ID",
     *      operationId="updateProducerReceiptArchives",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                  "customer_name",
     *                  "customer_tax_number",
     *                  "producer_receipt_date",
     *                  "producer_receipt_no",
     *                  "ettn",
     *                  "amount",
     *                  "status",
     *                  "gib_post_box_email",
     *                  "portal_status",
     *                  "connector_status",
     *              },
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="producer_receipt_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="producer_receipt_no", type="string", example="EMM2022000000006"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="company email"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt updated"),
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

    public function updateArchives(UpdateProducerReceiptArchiveRequest $request, $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       

        try{

            $receipt = ProducerReceiptArchive::where('user_id', $user->id)->find($id);
            if (!$receipt) {
                return response()->json([
                    'status' => false,
                    'message' => 'Receipt not found'
                ], 404);  
            }

            $data = $request->validated();
            $data['company_id'] = $user->hasRole('admin') ? $data['company_id'] : $user->company_id;
            $data['user_id'] = $user->id;

            $receipt->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: "  . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Delete producer receipt (archives) by ID
     * 
     * @OA\Delete(
     *      path="/user/producer-receipts/archives/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Delete producer receipt (archives) by ID",
     *      description="Delete producer receipt (archives) by ID",
     *      operationId="deleteProducerReceiptArchives",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (archives) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt deleted"),
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
    public function destroyArchives($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        
        try {
            $receipt = ProducerReceiptArchive::where('user_id', $user->id)->find($id);
            $receipt->delete();

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate UBL XML for producer receipt (archives)
     * 
     * @OA\Get(
     *      path="/user/producer-receipts/archives/{id}/ubl",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Generate UBL for producer receipt (archives) invoive",
     *      description="Generate UBL by providing the producer receipt (archives) ID",
     *      operationId="producerReceiptArchivesUbl",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the producer receipt (archives) to generate UBL for",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/xml",
     *              example="<?xml version='1.0' encoding='UTF-8'?>
     *                        <ProducerReceiptArchives xmlns='urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'>
     *                            <cbc:ID>{$producerReceipt->id}</cbc:ID>
     *                            <cbc:CompanyName>{$producerReceipt->company->company_name}</cbc:CompanyName>
     *                        </ProducerReceiptArchives>"
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
     *          description="Outgoing producer receipt not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      )
     * )
     */
    public function generateUblArchives($id)
    {
       // Retrieve the currently authenticated user.
       $user = auth()->user();
      
       
        // Include the company relationship if needed
        $receipt = ProducerReceiptArchive::with('company')->find($id);
        if (!$receipt || $receipt->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Not found or Unauthorized'
            ], 404);
        }

        // Create the XML document
        $xml = new \SimpleXMLElement('<ProducerReceiptArchives></ProducerReceiptArchives>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $receipt->id);
        $xml->addChild('cbc:CompanyName', $receipt->company->company_name);

        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        
        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }


    // METHODS FOR PRODUCER RECEIPT (CALLS)

    /**
     * Get producer receipt (archive) list  
     * 
     * @OA\Get(
     *      path="/user/producer-reciepts/calls",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get list of producer receipt (calls) and paginate",
     *      description="Get list of producer receipt (calls) associated with the authenticated user and paginate",
     *      operationId="getProducerReceiptsCalls",
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipts retrieved"),
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
    public function indexCalls($limit = 10)
    {
         // Retrieve the currently authenticated user.
         $user = auth()->user();

         try{

            $receipts = ProducerReceiptCall::where('user_id', $user->id)->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipts retrieved',
                'data' => $receipts
            ], 200);
 
         }catch(\Exception $e){
 
             return response()->json([
                 'status' => false,
                 'message' => "Internal server error: " . $e->getMessage(),
             ], 500);
         }
    }

    /**
     * Create producer receipt (calls)
     * 
     * @OA\Post(
     *      path="/user/producer-receipts/calls",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Create producer receipt (calls)",
     *      description="Create producer receipt (calls)",
     *      operationId="createProducerReceiptCalls",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                  "sender_company",
     *                   "sender_company_vkn",
     *                   "sender_company_mailbox",
     *                   "customer_name",
     *                   "customer_tax_number",
     *                   "mm_tarihi",
     *                   "mm_no",
     *                   "ettn",
     *                   "amount",
     *                   "status",
     *                   "gib_post_box_email",
     *                   "portal_status",
     *                   "connector_status",
     *                   "cancell_status",
     *                   "is_archive",
     *              },
     *              @OA\Property(property="sender_company", type="string", example="RANDOM Company"),
     *              @OA\Property(property="sender_company_vkn", type="string", example="3230512384"),
     *              @OA\Property(property="sender_company_mailbox", type="string", example="company email"),
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="3230512384"),
     *              @OA\Property(property="mm_tarihi", type="string", example="26/01/2024"),
     *              @OA\Property(property="mm_no", type="string", example="EMM2024000000022"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="gib email"),
     *              @OA\Property(property="portal_status", type="string", example="Email sending"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="cancell_status", type="string", example="status"),
     *              @OA\Property(property="is_archive", type="boolean", example="Yes"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt created"),
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
    public function storeCalls(StoreProducerReceiptCallRequest $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        
        try{

            $receipt = $request->validated();
            $receipt['last_update_user'] = $user->name;
            $receipt['company_id'] = $user->hasRole('admin') ? $receipt['company_id'] : $user->company_id;
            $receipt['user_id'] = $user->id;

            ProducerReceiptCall::create($receipt);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt created',
                'data' => $receipt
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Get producer receipt (calls) by ID
     * 
     * @OA\Get(
     *      path="/user/producer-receipts/calls/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get producer receipt (calls) by ID",
     *      description="Get producer receipt (calls) by ID",
     *      operationId="getProducerReceiptCallsById",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (calls) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt retrieved"),
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
    public function showCalls($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       

        try {

            $receipt = ProducerReceiptCall::find($id);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipt retrieved',
                'data' => $receipt
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update producer receipt (calls) by ID
     * 
     * @OA\Put(
     *      path="/user/producer-receipts/calls/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Update producer receipt (calls) by ID",
     *      description="Update producer receipt (calls) by ID",
     *      operationId="updateProducerReceiptCalls",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
        *              "sender_company", 
        *              "sender_company_vkn", 
        *              "sender_company_mailbox", 
        *              "customer_name", 
        *              "customer_tax_number", 
        *              "mm_tarihi", 
        *              "mm_no", "ettn", 
        *              "amount", 
        *              "status", 
        *              "gib_post_box_email", 
        *              "portal_status", 
        *              "connector_status", 
        *              "cancell_status", 
        *              "is_archive"
     *              },
     *              @OA\Property(property="sender_company", type="string", example="RANDOM Company"),
     *              @OA\Property(property="sender_company_vkn", type="string", example="3230512384"),
     *              @OA\Property(property="sender_company_mailbox", type="string", example="company email"),
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="3230512384"),
     *              @OA\Property(property="mm_tarihi", type="string", example="26/01/2024"),
     *              @OA\Property(property="mm_no", type="string", example="EMM2024000000022"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="gib email"),
     *              @OA\Property(property="portal_status", type="string", example="Email sending"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="cancell_status", type="string", example="status"),
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
     *              @OA\Property(property="message", type="string", example="Producer receipt updated"),
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

    

    public function updateCalls(UpdateProducerReceiptCallRequest $request, $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       

        try{

            $receipt = ProducerReceiptCall::where('user_id', $user->id)->find($id);
            if (!$receipt) {
                return response()->json([
                    'status' => false,
                    'message' => 'Receipt not found'
                ], 404);  
            }

            $data = $request->validated();
            $data['last_update_user'] = $user->name;
            $data['company_id'] = $user->hasRole('admin') ? $data['company_id'] : $user->company_id;
            $data['user_id'] = $user->id;

            $receipt->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: "  . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Delete producer receipt (calls) by ID
     * 
     * @OA\Delete(
     *      path="/user/producer-receipts/calls/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Delete producer receipt (calls) by ID",
     *      description="Delete producer receipt (calls) by ID",
     *      operationId="deleteProducerReceiptCalls",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (calls) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt deleted"),
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
    public function destroyCalls($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        
        try {
            $receipt = ProducerReceiptCall::where('user_id', $user->id)->find($id);
            $receipt->delete();

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate UBL XML for producer receipt (calls)
     * 
     * @OA\Get(
     *      path="/user/producer-receipts/calls/{id}/ubl",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Generate UBL for producer receipt (calls) invoice",
     *      description="Generate UBL by providing the producer receipt (calls) ID",
     *      operationId="producerReceiptCallsUbl",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the producer receipt (calls) to generate XML for",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/xml",
     *              example="<?xml version='1.0' encoding='UTF-8'?>
     *                        <ProducerReceiptCalls xmlns='urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'>
     *                            <cbc:ID>{$producerReceipt->id}</cbc:ID>
     *                            <cbc:CompanyName>{$producerReceipt->company->company_name}</cbc:CompanyName>
     *                        </ProducerReceiptCalls>"
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
     *          description="Outgoing producer receipt not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      )
     * )
     */
    public function generateUblCalls($id)
    {
       // Retrieve the currently authenticated user.
       $user = auth()->user();
      
       
        // Include the company relationship if needed
        $receipt = ProducerReceiptCall::with('company')->find($id);
        if (!$receipt || $receipt->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Not found or Unauthorized'
            ], 404);
        }

        // Create the XML document
        $xml = new \SimpleXMLElement('<ProducerReceiptCalls></ProducerReceiptCalls>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $receipt->id);
        $xml->addChild('cbc:CompanyName', $receipt->company->company_name);

        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        
        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }
    
    
    // METHODS FOR PRODUCER RECEIPT (CANCELLATIONS)

    /**
     * Get producer receipt list (cancellations) 
     * 
     * @OA\Get(
     *      path="/user/producer-reciepts/cancellations",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get list of producer receipt (cancellations) and paginate",
     *      description="Get list of producer receipt (cancellations) associated with the authenticated user and paginate",
     *      operationId="getProducerReceiptsCancellations",
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipts retrieved"),
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
    public function indexCancellations($limit = 10)
    {
         // Retrieve the currently authenticated user.
         $user = auth()->user();

         try{

            $receipts = ProducerReceiptCancellation::where('user_id', $user->id)->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipts retrieved',
                'data' => $receipts
            ], 200);
 
         }catch(\Exception $e){
 
             return response()->json([
                 'status' => false,
                 'message' => "Internal server error: " . $e->getMessage(),
             ], 500);
         }
    }

    /**
     * Create producer receipt (cancellations)
     * 
     * @OA\Post(
     *      path="/user/producer-receipts/cancellations",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Create producer receipt (cancellations)",
     *      description="Create producer receipt (cancellations)",
     *      operationId="createProducerReceiptCancellations",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                  "customer_name",
     *                  "customer_tax_number",
     *                  "producer_receipt_date",
     *                  "producer_receipt_no",
     *                  "ettn",
     *                  "amount",
     *                  "status",
     *                  "gib_post_box_email",
     *                  "mail_delivery_status",
     *                  "portal_status",
     *                  "connector_status",
     *                  "cancellation_time",
     *              },
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="producer_receipt_date", type="datetime", example="2024-03-31"),
     *              @OA\Property(property="producer_receipt_no", type="string", example="EMM2022000000006"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="company email"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="cancellation_time", type="datetime", example="2024-03-31 12:20:25"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt created"),
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
    public function storeCancellations(StoreProducerReceiptCancellationRequest $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        
        try{

            $receipt = $request->validated();
            $receipt['last_update_user'] = $user->name;
            $receipt['company_id'] = $user->hasRole('admin') ? $receipt['company_id'] : $user->company_id;
            $receipt['user_id'] = $user->id;

            ProducerReceiptCancellation::create($receipt);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt created',
                'data' => $receipt
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Get producer receipt (cancellations) by ID
     * 
     * @OA\Get(
     *      path="/user/producer-receipts/cancellations/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get producer receipt (cancellations) by ID",
     *      description="Get producer receipt  (cancellations) by ID",
     *      operationId="getProducerReceiptCancellationsById",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (cancellations) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt retrieved"),
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
    public function showCancellations($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        try {

            $receipt = ProducerReceiptCancellation::where('user_id', $user->id)->find($id);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipt retrieved',
                'data' => $receipt
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update producer receipt  (cancellations) by ID
     * 
     * @OA\Put(
     *      path="/user/producer-receipts/cancellations/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Update producer receipt  (cancellations) by ID",
     *      description="Update producer receipt  (cancellations) by ID",
     *      operationId="updateProducerReceiptCancellations",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt  (cancellations) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                 "customer_name",
     *                  "customer_tax_number",
     *                  "producer_receipt_date",
     *                  "producer_receipt_no",
     *                  "ettn",
     *                  "amount",
     *                  "status",
     *                  "gib_post_box_email",
     *                  "mail_delivery_status",
     *                  "portal_status",
     *                  "connector_status",
     *                  "cancellation_time",
     *              },
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="producer_receipt_date", type="datetime", example="2024-03-31"),
     *              @OA\Property(property="producer_receipt_no", type="string", example="EMM2022000000006"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="company email"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="cancellation_time", type="datetime", example="2024-03-31 12:20:25"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt updated"),
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

    public function updateCancellations(UpdateProducerReceiptCancellationRequest $request, $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       

        try{

            $receipt = ProducerReceiptCancellation::where('user_id', $user->id)->find($id);
            if (!$receipt) {
                return response()->json([
                    'status' => false,
                    'message' => 'Receipt not found'
                ], 404);  
            }

            $data = $request->validated();
            $data['last_update_user'] = $user->name;
            $data['company_id'] = $user->hasRole('admin') ? $data['company_id'] : $user->company_id;
            $data['user_id'] = $user->id;

            $receipt->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: "  . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Delete producer receipt (cancellations) by ID
     * 
     * @OA\Delete(
     *      path="/user/producer-receipts/cancellations/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Delete producer receipt (cancellations) by ID",
     *      description="Delete producer receipt (cancellations) by ID",
     *      operationId="deleteProducerReceiptCancellations",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (cancellations) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt deleted"),
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
    public function destroyCancellations($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        
        try {
            $receipt = ProducerReceiptCancellation::where('user_id', $user->id)->find($id);
            $receipt->delete();

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate UBL XML for producer receipt (cancellations)
     * 
     * @OA\Get(
     *      path="/user/producer-receipts/cancellations/{id}/ubl",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Generate UBL for producer receipt (cancellation) invoice",
     *      description="Generate UBL by providing the producer receipt (cancellations) ID",
     *      operationId="producerReceiptCancellationsUbl",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the producer receipt (cancellations) to generate XML for",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/xml",
     *              example="<?xml version='1.0' encoding='UTF-8'?>
     *                        <OutgoingProducerReceipt xmlns='urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'>
     *                            <cbc:ID>{$producerReceipt->id}</cbc:ID>
     *                            <cbc:CompanyName>{$producerReceipt->company->company_name}</cbc:CompanyName>
     *                        </OutgoingProducerReceipt>"
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
     *          description="Outgoing producer receipt not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      )
     * )
     */
    public function generateUblCancellations($id)
    {
       // Retrieve the currently authenticated user.
       $user = auth()->user();
      
       
        // Include the company relationship if needed
        $receipt = ProducerReceiptCancellation::where('user_id', $user->id)->with('company')->find($id);
        if (!$receipt || $receipt->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Not found or Unauthorized'
            ], 404);
        }

        // Create the XML document
        $xml = new \SimpleXMLElement('<ProducerReceiptCancellation></ProducerReceiptCancellation>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $receipt->id);
        $xml->addChild('cbc:CompanyName', $receipt->company->company_name);

        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        
        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }
    


    // METHODS FOR PRODUCER RECEIPT (OUTGOINGS)

    /**
     * Get producer receipt list (outgoings) 
     * 
     * @OA\Get(
     *      path="/user/producer-reciepts/outgoings",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get list of producer receipt (outgoings) and paginate",
     *      description="Get list of producer receipt (outgoings) associated with the authenticated user and paginate",
     *      operationId="getProducerReceiptsOutgoings",
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          @OA\Schema(type="integer", default=10)
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipts retrieved"),
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
    public function indexOutgoings($limit = 10)
    {
         // Retrieve the currently authenticated user.
         $user = auth()->user();

         try{

            $receipts = ProducerReceiptOutgoing::where('user_id', $user->id)->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipts retrieved',
                'data' => $receipts
            ], 200);
 
         }catch(\Exception $e){
 
             return response()->json([
                 'status' => false,
                 'message' => "Internal server error: " . $e->getMessage()
             ], 500);
         }
    }

    /**
     * Create producer receipt (outgoings)
     * 
     * @OA\Post(
     *      path="/user/producer-reciepts/outgoings",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Create producer receipt (outgoings)",
     *      description="Create producer receipt (outgoings)",
     *      operationId="createProducerReceiptOutgoings",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                  "customer_name", 
     *                  "customer_tax_number",
     *                  "producer_receipt_date",
     *                  "mm_no",
     *                  "amount",
     *                  "status",
     *                  "ettn",
     *                  "gib_post_box_email",
     *                  "mail_delivery_status",
     *                  "portal_status",
     *                  "connector_status",
     *              },
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="producer_receipt_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="mm_no", type="string", example="EMM2024000000022"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="company email"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
 *             @OA\Property(property="company_id", type="string", example="1"),
     * 
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt created"),
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
    public function storeOutgoings(StoreProducerReceiptOutgoingRequest $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
      
        try{

            $receipt = $request->validated();
            $receipt['last_update_user'] = $user->name;
            $receipt['company_id'] = $user->hasRole('admin') ? $receipt['company_id'] : $user->company_id;
            $receipt['user_id'] = $user->id;

            ProducerReceiptOutgoing::create($receipt);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt created',
                'data' => $receipt
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Get producer receipt (outgoings) by ID
     * 
     * @OA\Get(
     *      path="/user/producer-reciepts/outgoings/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Get producer receipt (outgoings) by ID",
     *      description="Get producer receipt (outgoings) by ID",
     *      operationId="getProducerReceiptOutgoingsById",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (outgoings) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt retrieved"),
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
    public function showOutgoings($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        
        try {

            $receipt = ProducerReceiptOutgoing::where('user_id', $user->id)->find($id);
            return response()->json([
                'status' => true,
                'message' => 'Producer receipt retrieved',
                'data' => $receipt
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update producer receipt (outgoings) by ID
     * 
     * @OA\Put(
     *      path="/user/producer-reciepts/outgoings{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Update producer receipt (outgoings) by ID",
     *      description="Update producer receipt (outgoings) by ID",
     *      operationId="updateProducerReceiptOutgoings",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (outgoings) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={
     *                  "customer_name", 
     *                  "customer_tax_number",
     *                  "producer_receipt_date",
     *                  "mm_no",
     *                  "amount",
     *                  "status",
     *                  "ettn",
     *                  "gib_post_box_email",
     *                  "mail_delivery_status",
     *                  "portal_status",
     *                  "connector_status",
     *              },
     *              @OA\Property(property="customer_name", type="string", example="John Doe"),
     *              @OA\Property(property="customer_tax_number", type="string", example="1234567890"),
     *              @OA\Property(property="producer_receipt_date", type="datetime", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="mm_no", type="string", example="EMM2024000000022"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="status", type="string", example="pending"),
     *              @OA\Property(property="ettn", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="gib_post_box_email", type="string", example="company email"),
     *              @OA\Property(property="mail_delivery_status", type="string", example="pending"),
     *              @OA\Property(property="portal_status", type="string", example="processing"),
     *              @OA\Property(property="connector_status", type="string", example="unread"),
     *              @OA\Property(property="last_update_user", type="string", example="last_update_user"),
     *              @OA\Property(property="company_id", type="integer", example="1"),
     *              @OA\Property(property="user_id", type="integer", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt updated"),
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

    public function updateOutgoings(UpdateProducerReceiptOutgoingRequest $request, $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       

        try{

            $receipt = ProducerReceiptOutgoing::where('user_id', $user->id)->find($id);
            if (!$receipt) {
                return response()->json([
                    'status' => false,
                    'message' => 'Receipt not found'
                ], 404);  
            }

            $data = $request->validated();
            $data['last_update_user'] = $user->name;
            $data['company_id'] = $user->hasRole('admin') ? $data['company_id'] : $user->company_id;
            $data['user_id'] = $user->id;

            $receipt->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error: "  . $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Delete producer receipt (outgoings) by ID
     * 
     * @OA\Delete(
     *      path="/user/producer-reciepts/outgoings/{id}",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Delete producer receipt (outgoings) by ID",
     *      description="Delete producer receipt (outgoings) by ID",
     *      operationId="deleteProducerReceiptOutgoings",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Producer receipt (outgoings) ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Producer receipt deleted"),
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
    public function destroyOutgoings($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       
        
        try {
            $receipt = ProducerReceiptOutgoing::where('user_id', $user->id)->find($id);
            $receipt->delete();

            return response()->json([
                'status' => true,
                'message' => 'Producer receipt deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate UBL XML for producer receipt (outgoings)
     * 
     * @OA\Get(
     *      path="/user/producer-reciepts/outgoings/{id}/ubl",
     *      tags={"Outgoing Producer Receipt"},
     *      summary="Generate UBL for producer receipt invoice",
     *      description="Generate UBL by providing the producer receipt (outgoings) ID",
     *      operationId="producerReceiptOutgoingsUbl",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the producer receipt (outgoings) to generate XML for",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/xml",
     *              example="<?xml version='1.0' encoding='UTF-8'?>
     *                        <ProducerReceiptOutgoings xmlns='urn:oasis:names:specification:ubl:schema:xsd:Invoice-2'>
     *                            <cbc:ID>{$producerReceipt->id}</cbc:ID>
     *                            <cbc:CompanyName>{$producerReceipt->company->company_name}</cbc:CompanyName>
     *                        </ProducerReceiptOutgoings>"
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
     *          description="Producer receipt not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Not found")
     *          )
     *      )
     * )
     */
    public function generateUblOutgoings($id)
    {
       // Retrieve the currently authenticated user.
       $user = auth()->user();
      
       
        // Include the company relationship if needed
        $receipt = ProducerReceiptOutgoing::where('user_id', $user->id)->with('company')->find($id);
        if (!$receipt || $receipt->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Not found or Unauthorized'
            ], 404);
        }

        // Create the XML document
        $xml = new \SimpleXMLElement('<ProducerReceiptOutgoings></ProducerReceiptOutgoings>');
        $xml->addAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xml->addAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xml->addAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        // Populate the XML document with invoice data
        $xml->addChild('cbc:ID', $receipt->id);
        $xml->addChild('cbc:CompanyName', $receipt->company->company_name);

        // Convert the SimpleXMLElement object to XML string
        $xmlString = $xml->saveXML();
        
        // You can save or return the XML string as needed
        return response()->json([
            'status' => true,
            'xml' =>  $xmlString
        ]);
    }
}