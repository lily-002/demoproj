<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /** List Company
     * @OA\Get(
     * path="/admin/companies",
     * summary="List Company",
     * description="List Company",
     * operationId="listCompany",
     * tags={"Company"},
     * * @OA\Parameter(
    *   name="limit",
    * in="query",
    * description="Limit",
    * required=false,
    * @OA\Schema(
    *      type="integer"
    * )
    * ),
    * @OA\Response(
    *    response=200,
    *    description="List Company",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="true"),
    *       @OA\Property(property="message", type="string", example="List Company"),
    *        )
    *     ),
    * @OA\Response(
    *    response=400,
    *    description="Company List Failed",
    *    @OA\JsonContent(
    *       @OA\Property(property="success", type="boolean", example="false"),
    *       @OA\Property(property="message", type="string", example="Company List Failed"),
    *        )
    *     ),
    * )
    */
    public function listCompany(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        try {
            $limit = $request->limit ?? 10;
            // Get all companies associated with the user
            $companies = $user->companies()->paginate($limit);

            return response()->json([
                'status' => true,
                'message' => 'List Company',
                'data' => $companies
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Company List Failed',
            ], 400);
        }
    }
    //  'company_name',
    // 'tax_number',
    // 'tax_office',
    // 'mersis_number',
    // 'business_registry_number',
    // 'operating_center',
    // 'country',
    // 'city',
    // 'address',
    // 'email',
    // 'phone_number',
    // 'website',
    // 'gib_registration_data',
    // 'gib_sender_alias',
    // 'gib_receiver_alias',
    // 'e-signature_method',
    // 'date_of_last_update',
    // 'last_update_user',
    // 'user_id',

    // Create Company
    /**
     * @OA\Post(
     * path="/admin/companies",
     * summary="Create Company",
     * description="Create Company",
     * operationId="createCompany",
     * tags={"Company"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Create Company",
     *    @OA\JsonContent(
     *       required={"company_name", "tax_number", "tax_office", "mersis_number", "business_registry_number", "operating_center", "country", "city", "address", "email", "phone_number", "website", "gib_registration_data", "gib_sender_alias", "gib_receiver_alias", "e-signature_method", "date_of_last_update", "last_update_user", "user_id"},
     *       @OA\Property(property="company_name", type="string", format="text", example="Company Name"),
     *       @OA\Property(property="tax_number", type="string", format="text", example="Tax Number"),
     *       @OA\Property(property="tax_office", type="string", format="text", example="Tax Office"),
     *       @OA\Property(property="mersis_number", type="string", format="text", example="Mersis Number"),
     *       @OA\Property(property="business_registry_number", type="string", format="text", example="Business Registry Number"),
     *       @OA\Property(property="operating_center", type="string", format="text", example="Operating Center"),
     *       @OA\Property(property="country", type="string", format="text", example="Country"),
     *       @OA\Property(property="city", type="string", format="text", example="City"),
     *       @OA\Property(property="address", type="string", format="text", example="Address"),
     *       @OA\Property(property="email", type="string", format="text", example="Email"),
     *       @OA\Property(property="phone_number", type="string", format="text", example="Phone Number"),
     *       @OA\Property(property="website", type="string", format="text", example="Website"),
     *       @OA\Property(property="gib_registration_data", type="string", format="date", example="2022-01-01"),
     *       @OA\Property(property="gib_sender_alias", type="string", format="text", example="Gis Sender Alias"),
     *      @OA\Property(property="gib_receiver_alias", type="string", format="text", example="Gis Receiver Alias"),
     *     @OA\Property(property="e-signature_method", type="string", format="text", example="E-Signature Method"),
     *    @OA\Property(property="date_of_last_update", type="string", format="date", example="2022-01-01"),
     *   @OA\Property(property="last_update_user", type="string", format="text", example="Last Update User"),
     *       )
     *   ),
     * @OA\Response(
     *   response=200,
     *  description="Company Created",
     * @OA\JsonContent(
     *      @OA\Property(property="success", type="boolean", example="true"),
     *     @OA\Property(property="message", type="string", example="Company Created"),
     *     )
     * ),
     * @OA\Response(
     *  response=400,
     * description="Company Creation Failed",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *    @OA\Property(property="message", type="string", example="Company Creation Failed"),
     *    )
     * )
     * )
     */
    public function createCompany(Request $request)
    {
        // // Get the authenticated user
        $user = auth()->user();
        // print_r($request->all());
        try {
            // Create a new company
            $company = $user->companies()->create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Company Created',
                'data' => $company
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Company Creation Failed',
            ], 400);
        }
    }

    // Show Company
    /**
     * @OA\Get(
     * path="/admin/companies/{id}",
     * summary="Show Company",
     * description="Show Company",
     * operationId="showCompany",
     * tags={"Company"},
     * @OA\Parameter(
     *    description="ID of company to return",
     *    in="path",
     *    name="id",
     *    required=true,
     *    @OA\Schema(
     *       type="integer"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Show Company",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="Show Company"),
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Company Show Failed",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Company Show Failed"),
     *        )
     *     ),
     * )
     */
    public function showCompany($id)
    {
        // Get the authenticated user
        $user = auth()->user();

        try {
            // Get the company
            $company = $user->companies()->find($id);

            return response()->json([
                'status' => true,
                'message' => 'Show Company',
                'data' => $company
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Company Show Failed',
            ], 400);
        }
    }

    // Update Company
    /**
     * @OA\Put(
     * path="/admin/companies/{id}",
     * summary="Update Company",
     * description="Update Company",
     * operationId="updateCompany",
     * tags={"Company"},
     * @OA\Parameter(
     *    description="ID of company to update",
     *    in="path",
     *    name="id",
     *    required=true,
     *    @OA\Schema(
     *       type="integer"
     *    )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Update Company",
     *    @OA\JsonContent(
     *       required={"company_name", "tax_number", "tax_office", "mersis_number", "business_registry_number", "operating_center", "country", "city", "address", "email", "phone_number", "website", "gib_registration_data", "gib_sender_alias", "gib_receiver_alias", "e-signature_method", "date_of_last_update", "last_update_user", "user_id"},
     *       @OA\Property(property="company_name", type="string", format="text", example="Company Name"),
     *       @OA\Property(property="tax_number", type="string", format="text", example="Tax Number"),
     *       @OA\Property(property="tax_office", type="string", format="text", example="Tax Office"),
     *       @OA\Property(property="mersis_number", type="string", format="text", example="Mersis Number"),
     *       @OA\Property(property="business_registry_number", type="string", format="text", example="Business Registry Number"),
     *       @OA\Property(property="operating_center", type="string", format="text", example="Operating Center"),
     *       @OA\Property(property="country", type="string", format="text", example="Country"),
     *       @OA\Property(property="city", type="string", format="text", example="City"),
     *       @OA\Property(property="address", type="string", format="text", example="Address"),
     *       @OA\Property(property="email", type="string", format="text", example="Email"),
     *       @OA\Property(property="phone_number", type="string", format="text", example="Phone Number"),
     *      @OA\Property(property="website", type="string", format="text", example="Website"),
     *     @OA\Property(property="gib_registration_data", type="string", format="date", example="2022-01-01"),
     *    @OA\Property(property="gib_sender_alias", type="string", format="text", example="Gis Sender Alias"),
     *  @OA\Property(property="gib_receiver_alias", type="string", format="text", example="Gis Receiver Alias"),
     * @OA\Property(property="e-signature_method", type="string", format="text", example="E-Signature Method"),
     * @OA\Property(property="date_of_last_update", type="string", format="date", example="2022-01-01"),
     * @OA\Property(property="last_update_user", type="string", format="text", example="Last Update User"),
     *      )
     *  ),
     * @OA\Response(
     *   response=200,
     * description="Company Updated",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="true"),
     *   @OA\Property(property="message", type="string", example="Company Updated"),
     *  )
     * ),
     * @OA\Response(
     * response=400,
     * description="Company Update Failed",
     * @OA\JsonContent(
     *   @OA\Property(property="success", type="boolean", example="false"),
     * @OA\Property(property="message", type="string", example="Company Update Failed"),
     * )
     * )
     * )
     */
    public function updateCompany(UpdateCompanyRequest $request,  $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }

         // Get the company
        $company = $user->companies()->find($id);


        try {
        if(!$company){
             return response()->json([
                'status' => false,
                'message' => 'You\'re not authorized to update this company',
                'data' => $company
            ], 200);
        }


            // Update the company with validated data
            $company->update($request->validated());
    
            return response()->json([
                'status' => true,
                'message' => 'Company updated successfully',
                'data' => $company
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error, try again',
            ], 500);
        }
    }

    // Delete Company
    /**
     * @OA\Delete(
     * path="/admin/companies/{id}",
     * summary="Delete Company",
     * description="Delete Company",
     * operationId="deleteCompany",
     * tags={"Company"},
     * @OA\Parameter(
     *    description="ID of company to delete",
     *    in="path",
     *    name="id",
     *    required=true,
     *    @OA\Schema(
     *       type="integer"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Company Deleted",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="Company Deleted"),
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Company Deletion Failed",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Company Deletion Failed"),
     *        )
     *     ),
     * )
     */
    public function deleteCompany($id)
    {
        // Get the authenticated user
        $user = auth()->user();

        try {
            // Get the company
            $company = $user->companies()->find($id);

            if (!$company) {
                return response()->json([
                    'status' => false,
                    'message' => 'Company Not Found',
                ], 404);
            }

            // Delete the company
            $company->delete();

            return response()->json([
                'status' => true,
                'message' => 'Company Deleted',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Company Deletion Failed',
            ], 400);
        }
    }
        
}