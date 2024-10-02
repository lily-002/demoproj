<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;

class UsersController extends Controller
{
    /** List of users that admin added
     * @OA\Get(
     *  path="/admin/users",
     *  summary="List of users that admin added",
     *  tags={"Manage Admin Users"},
     *  @OA\Response(
     *     response=200,
     *    description="List of users",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="List of users"),
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
    public function listUsers()
    {
        $user = auth()->user();

        try {
            // Retrieve companies associated with the authenticated user
            $companies = $user->companies()->get();

            $users = [];
            // Loop through each company
            foreach ($companies as $company) {
                // Retrieve users belonging to the current company, excluding the current user
                $companyUsers = $company->users()->where('id', '!=', $user->id)->get();
                // Merge the users of the current company into the $users array
               // Loop through each user to add the company name
                foreach ($companyUsers as $companyUser) {
                    $companyUserArray = $companyUser->toArray();
                    unset($companyUserArray['company_id']);
                    $companyUserArray['company_name'] = $company->company_name;
                    $users[] = $companyUserArray;
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'List of users',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Something went wrong",
                
            ], 500);
        }
    }


    /** Get users for a company
        * @OA\Get(
        *  path="/admin/users/company/{id}",
        *  summary="Get users for a company",
        *  tags={"Manage Admin Users"},
        *  @OA\Parameter(
        *      name="id",
        *      in="path",
        *      description="Company id",
        *      required=true,
        *      @OA\Schema(
        *          type="integer"
        *      )
        *  ),
        *  @OA\Response(
        *     response=200,
        *    description="List of users for a company",
        *   @OA\JsonContent(
        *       @OA\Property(property="success", type="boolean", example="true"),
        *       @OA\Property(property="message", type="string", example="List of users for a company"),
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
    public function listUsersForCompany($id)
    {
        $user = auth()->user();

        try {
            // Check if the company is associated with the authenticated user
            $isCompanyforUser = $user->companies()->find($id);
            if (!$isCompanyforUser) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to view users for this company'
                ], 404);
            }

            // Retrieve the company
            $company = Company::find($id);
            if (!$company) {
                return response()->json([
                    'status' => false,
                    'message' => 'Company not found'
                ], 404);
            }

            // Retrieve users belonging to the company, excluding the current user
            $companyUsers = $company->users()->where('id', '!=', $user->id)->get();
            $users = [];

            // Loop through each user to add the company name and remove the company_id
            foreach ($companyUsers as $companyUser) {
                $companyUserArray = $companyUser->toArray();
                unset($companyUserArray['company_id']); // Remove the company_id field
                $companyUserArray['company_name'] = $company->company_name;
                $users[] = $companyUserArray;
            }


            return response()->json([
                'status' => true,
                'message' => 'List of users for the company',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Something went wrong",
            ], 500);
        }
    }


    /** Add a user to a company
     * @OA\Post(
     *  path="/admin/users",
     *  summary="Add a user to a company",
     *  tags={"Manage Admin Users"},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"name","email","phone","username","password","company_id"},
     *          @OA\Property(property="name", type="string", format="name", example="John Doe"),
     *          @OA\Property(property="email", type="string", format="email", example="example@email.com"),
     *          @OA\Property(property="phone", type="string", format="phone", example="1234567890"),
     *          @OA\Property(property="mobile", type="string", format="phone", example="1234567890"),
     *          @OA\Property(property="username", type="string", format="username", example="johndoe"),
     *          @OA\Property(property="password", type="string", format="password", example="password"),
     *          @OA\Property(property="notification_einvoice", type="boolean",  example="false"),
     *          @OA\Property(property="notification_edispatch", type="boolean",  example="false"),
     *          @OA\Property(property="luca_username", type="string", example="luca_username"),
     *          @OA\Property(property="luca_member_number", type="string", format="luca_member_number", example="luca_member_number"),
     *          @OA\Property(property="luca_password", type="string", format="luca_password", example="luca_password"),
     *          @OA\Property(property="export_only", type="boolean", format="export_only", example="false"),
     *          @OA\Property(property="earchive", type="boolean", format="earchive", example="false"),
     *          @OA\Property(property="einvoice_only", type="boolean", format="einvoice_only", example="false"),
     *          @OA\Property(property="ssi_only", type="boolean", format="ssi_only", example="false"),
     *          @OA\Property(property="company_id", type="integer", format="company_id", example="1"),
     *     )
     * ),
     * @OA\Response(
     *    response=201,
     *  description="User created successfully",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="User created successfully"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", example="example@email.com"),
     * @OA\Property(property="phone", type="string", example="1234567890"),
     * @OA\Property(property="username", type="string", example="johndoe"),
     * @OA\Property(property="company_id", type="integer", example="1"),
     * @OA\Property(property="updated_at", type="string", example="2021-09-01T12:00:00.000000Z"),
     * @OA\Property(property="created_at", type="string", example="2021-09-01T12:00:00.000000Z"),
     * @OA\Property(property="id", type="integer", example="1"),
     * )
     * )
     * ),
     * @OA\Response(
     *   response=400,
     * description="User already exists",
     * @OA\JsonContent(
     *    @OA\Property(property="success", type="boolean", example="false"),    
     * @OA\Property(property="message", type="string", example="User already exists"),
     * )
     * ),
     * @OA\Response(
     *  response=500,
     * description="An error occurred",
     * @OA\JsonContent(
     *    @OA\Property(property="success", type="boolean", example="false"),
     * @OA\Property(property="message", type="string", example="An error occurred"),
     * )
     * )
     * )
     */
   
    public function createUser(AddUserRequest $request)
    {

        $user = auth()->user();
        $validated = $request->validated();

        try {
            // Hash the password
            $validated['password'] = bcrypt($request->password);
            $validated['luca_password'] = bcrypt($request->luca_password);
            // Associate the user with the specified company
                $company = $user->companies()->find($request->company_id);
                if ($company) {
                    $newUser = $company->users()->create($validated);
                    $newUser->assignRole('user');
                    $newUser->company()->associate($company);
                    $newUser->save();
                }
                else {
                    return response()->json([
                        'status' => false,
                        'message' => 'You are not authorized to add a user to this company'
                    ], 404);
                }

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $newUser
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "An error occurred "
            ], 500);
        }
    }

    /** Show a user
     * @OA\Get(
     *  path="/admin/users/{id}",
     *  summary="Show a user",
     *  tags={"Manage Admin Users"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="User id",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response(
     *     response=200,
     *    description="User details",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="User details"),
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
     *   response=404,
     * description="User not found",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="User not found"),
     * )
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
    public function showUser($id)
    {
        $user = auth()->user();
        
        try {
            // Check if the authenticated user belongs to the same company as the user to be shown
            $company = $user->companies()->whereHas('users', function ($query) use ($id) {
                $query->where('id', $id);
            })->first();
            
            // Retrieve the user details if the company is found
            if ($company) {
                // Exclude the current logged-in user from the query results
                $userDetails = $company->users()->where('id', '!=', $user->id)->where('id', $id)->first();
                if ($userDetails) {
                    $userDetailsArray = $userDetails->toArray();
                    $userDetailsArray['company_name'] = $company->company_name;
                    return response()->json([
                        'status' => true,
                        'message' => 'User details',
                        'data' => $userDetailsArray
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'User not found'
                    ], 404);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Something went wrong",
            ], 500);
        }
    }


    /** Update a user
     * @OA\Put(
     *  path="/admin/users/{id}",
     *  summary="Update a user",
     *  tags={"Manage Admin Users"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="User id",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"name","email","phone","username","password","company_id"},
     *        @OA\Property(property="name", type="string", format="name", example="John Doe"),
     *          @OA\Property(property="email", type="string", format="email", example="example@email.com"),
     *          @OA\Property(property="phone", type="string", format="phone", example="1234567890"),
     *          @OA\Property(property="mobile", type="string", format="phone", example="1234567890"),
     *          @OA\Property(property="username", type="string", format="username", example="johndoe"),
     *          @OA\Property(property="password", type="string", format="password", example="password"),
     *          @OA\Property(property="notification_einvoice", type="boolean", format="notification_einvoice", example="false"),
     *          @OA\Property(property="notification_edispatch", type="boolean", format="notification_edispatch", example="false"),
     *          @OA\Property(property="luca_username", type="string", format="luca_username", example="luca_username"),
     *          @OA\Property(property="luca_member_number", type="string", format="luca_member_number", example="luca_member_number"),
     *          @OA\Property(property="luca_password", type="string", format="luca_password", example="luca_password"),
     *          @OA\Property(property="export_only", type="boolean", format="export_only", example="false"),
     *          @OA\Property(property="earchive", type="boolean", format="earchive", example="false"),
     *          @OA\Property(property="einvoice_only", type="boolean", format="einvoice_only", example="false"),
     *          @OA\Property(property="ssi_only", type="boolean", format="ssi_only", example="false"),
     * 
     *    )
     * ),
     * @OA\Response(
     *   response=200,
     * description="User updated successfully",
     * @OA\JsonContent(
     *    @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="User updated successfully"),
     * ),
     * ),
     * @OA\Response(
     *  response=400,
     * description="User already exists",
     * @OA\JsonContent(
     *   @OA\Property(property="success", type="boolean", example="false"),
     * @OA\Property(property="message", type="string", example="User already exists"),
     * )
     *  ),
     * @OA\Response(
     * response=404,
     * description="User not found",
     * @OA\JsonContent(
     *   @OA\Property(property="success", type="boolean", example="false"),
     * @OA\Property(property="message", type="string", example="User not found"),
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="An error occurred",
     * @OA\JsonContent(
     *  @OA\Property(property="success", type="boolean", example="false"),
     * @OA\Property(property="message", type="string", example="An error occurred"),
     * )
     * )
     * )
     */
    public function updateUser(UpdateUserRequest $request, $id)
    {
        $user = auth()->user();

        try {
            // Retrieve the user to be updated
            $userToUpdate = User::find($id);
            if (!$userToUpdate) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Check if the authenticated user belongs to the same company as the user to be updated
            $company = $user->companies()->whereHas('users', function ($query) use ($id) {
                $query->where('id', $id);
            })->first();
            if (!$company) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Exclude the current logged-in user when their ID is passed
            if ($user->id == $id) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to update your own details'
                ], 403);
            }

            $userToUpdate->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }




    /** Delete a user
     * @OA\Delete(
     *  path="/admin/users/{id}",
     *  summary="Delete a user",
     *  tags={"Manage Admin Users"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="User id",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response(
     *     response=200,
     *    description="User deleted successfully",
     *   @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="User deleted successfully"),
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
     *   response=404,
     * description="User not found",
     * @OA\JsonContent(
     *     @OA\Property(property="success", type="boolean", example="false"),
     *   @OA\Property(property="message", type="string", example="User not found"),
     * )
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
    public function deleteUser($id)
    {
        $user = auth()->user();
        
        try {
            // Check if the authenticated user belongs to the same company as the user to be deleted
            $company = $user->companies()->whereHas('users', function ($query) use ($id) {
                $query->where('id', $id);
            })->first();
            
            // Check if the user to be deleted is not the authenticated user
            if (!$company || $user->id == $id) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to delete this user'
                ], 403);
            }
            
            // Find the user to be deleted
            $userToDelete = User::find($id);
            
            // Check if the user exists
            if (!$userToDelete) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            // Delete the user
            $userToDelete->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Something went wrong",
            ], 500);
        }
    }




}
