<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEledgerRequest;
use App\Http\Requests\UpdateEledgerRequest;
use App\Models\Eledger;
use Illuminate\Http\Request;

class EledgerController extends Controller
{
   
    /**
     * Get eledger receipt (archive) list by company id 
     * 
     * @OA\Get(
     *      path="/user/eledger",
     *      tags={"E-Ledger"},
     *      summary="Get list of eledgers",
     *      description="Get list of eledgers associated with the authenticated user and paginate",
     *      operationId="getEledgers",
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
     *              @OA\Property(property="message", type="string", example="Eledgers retrieved"),
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
    public function getEledgers($limit = 10)
    {
         // Retrieve the currently authenticated user.
         $user = auth()->user();

         try{

            $ledgers = Eledger::where('user_id', $user->id)->paginate($limit);

            return response()->json([
                'status' => true,
                'message' => 'Eledgers retrieved',
                'data' => $ledgers
            ], 200);
 
         }catch(\Exception $e){
 
             return response()->json([
                 'status' => false,
                 'message' => "Internal server error: " . $e->getMessage(),
             ], 500);
         }
    }

    /**
     * Create ledger
     * 
     * @OA\Post(
     *      path="/user/eledger",
     *      tags={"E-Ledger"},
     *      summary="Create ledger",
     *      description="Create ledger",
     *      operationId="addEledger",
     *      @OA\RequestBody(
     *          required=true, 
     *          @OA\JsonContent(
     *              required={
     *                  "account_name",
     *                  "transaction_type_id",
     *                  "amount",
     *                  "currency_id",
     *                  "transaction_date",
     *                  "description",
     *                  "status_id",
     *                  "category_id",
     *              },
     *              @OA\Property(property="account_name", type="string", example="John Doe"),
     *              @OA\Property(property="transaction_type_id", type="string", example="1"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="currency_id", type="string", example="1"),
     *              @OA\Property(property="transaction_date", type="string", format="date-time", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="description", type="string", example="Description"),
     *              @OA\Property(property="status_id", type="string", example="1"),
     *              @OA\Property(property="category_id", type="string", example="1"),
     *              @OA\Property(property="reference_number", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="tax_info_id", type="string", example="1"),
     *              @OA\Property(property="attachment_url", type="string", example="http://example.com/file.extension"),
     *              @OA\Property(property="tax_amount", type="number", example="500.00"),
     *              @OA\Property(property="payment_method_id", type="string", example="1"),
     *              @OA\Property(property="payer_name", type="string", example="John Doe"),
     *              @OA\Property(property="payer_id_number", type="string", example="123456789"),
     *              @OA\Property(property="file", type="string", format="binary")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="e-ledger created"),
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
    public function addELedger(CreateEledgerRequest $request)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();

        try{

            $eledger = $request->validated();

            $eledger['company_id'] = $user->hasRole('admin') ? $eledger['company_id'] : $user->company_id;
            $eledger['user_id'] = $user->id;
            $eledger['created_by'] = $user->name;
            $eledger['updated_by'] = $user->name;
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $url = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/eledgers'), $url);
                $eledger->attachment_url = $url;
            }

            Eledger::create($eledger);

            return response()->json([
                'status' => true,
                'message' => 'e-ledger created',
                'data' => $eledger
            ], 201);

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error".$e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Get ledger by ID
     * 
     * @OA\Get(
     *      path="/user/eledger/{id}",
     *      tags={"E-Ledger"},
     *      summary="Get ledger  by ID",
     *      description="Get ledger  by ID",
     *      operationId="getEledger",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="e-ledger  ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="e-ledger retrieved"),
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
    public function getEledger($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
        
        try {

            $eledger = Eledger::where('user_id', $user->id)->findOrFail($id);
 
            return response()->json([
                'status' => true,
                'message' => 'e-ledger retrieved',
                'data' => $eledger
            ], 200); 

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error"
            ], 500);
        }
    }

    /**
     * Update ledger by ID
     * 
     * @OA\Put(
     *      path="/user/eledger/{id}",
     *      tags={"E-Ledger"},
     *      summary="Update ledger by ID",
     *      description="Update ledger by ID",
     *      operationId="updateEledger",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="e-ledger ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true, 
     *          @OA\JsonContent(
     *              required={
     *                  "account_name",
     *                  "transaction_type_id",
     *                  "amount",
     *                  "currency_id",
     *                  "transaction_date",
     *                  "description",
     *                  "status_id",
     *                  "category_id",
     *              },
     *              @OA\Property(property="account_name", type="string", example="John Doe"),
     *              @OA\Property(property="transaction_type_id", type="string", example="1"),
     *              @OA\Property(property="amount", type="number", example="5000.00"),
     *              @OA\Property(property="currency_id", type="string", example="1"),
     *              @OA\Property(property="transaction_date", type="string", format="date-time", example="2024-03-31 12:20:25"),
     *              @OA\Property(property="description", type="string", example="Description"),
     *              @OA\Property(property="status_id", type="string", example="1"),
     *              @OA\Property(property="category_id", type="string", example="1"),
     *              @OA\Property(property="reference_number", type="string", example="60d7cf08-d73e-4b"),
     *              @OA\Property(property="tax_info_id", type="string", example="1"),
     *              @OA\Property(property="attachment_url", type="string", example="http://example.com/file.extension"),
     *              @OA\Property(property="tax_amount", type="number", example="500.00"),
     *              @OA\Property(property="payment_method_id", type="string", example="1"),
     *              @OA\Property(property="payer_name", type="string", example="John Doe"),
     *              @OA\Property(property="payer_id_number", type="string", example="123456789"),
     *              @OA\Property(property="file", type="string", format="binary")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="e-ledger updated"),
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
    public function updateEledger(UpdateEledgerRequest $request, $id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
       

        try{

            $eledger = Eledger::where('user_id', $user->id)->findOrFail($id);
            if (!$eledger) {
                return response()->json([
                    'status' => false,
                    'message' => 'E-Ledger not found'
                ], 404);  
            }

            $data = $request->validated();
            $data['company_id'] = $user->hasRole('admin') ? $data['company_id'] : $user->company_id;
            $data['user_id'] = $user->id;
            $eledger['updated_by'] = $user->name;

             if ($request->hasFile('file')) {
                $file = $request->file('file');
                $url = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/eledgers'), $url);
                $eledger->attachment_url = $url;
            }

            $eledger->update($data);

            return response()->json([
                'status' => true,
                'message' => 'e-ledger updated',
                'data' => $data
            ], 200); 

        } catch(\Exception $e){

            return response()->json([
                'status' => false,
                'message' => "Internal server error"
            ], 500); 
        }
    }

    /**
     * Delete ledger  by ID
     * 
     * @OA\Delete(
     *      path="/user/eledger/{id}",
     *      tags={"E-Ledger"},
     *      summary="Delete ledger  by ID",
     *      description="Delete ledger  by ID",
     *      operationId="deleteEledger",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="e-ledger  ID",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="e-ledger deleted"),
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
    public function deleteEledger($id)
    {
        // Retrieve the currently authenticated user.
        $user = auth()->user();
        
        try {
            $eledger = Eledger::where('user_id', $user->id)->findOrFail($id);
            $eledger->delete();

            return response()->json([
                'status' => true,
                'message' => 'e-ledger deleted'
            ], 200);
           
        } catch (\Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }


}
