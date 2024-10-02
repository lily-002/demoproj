<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
      /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Get(
     *     path="/user/me",
     *     summary="Get user",
     *     description="Get user",
     *     operationId="me",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object", example="{}"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized"),
     *         ),
     *     ),
     * )
     */

    public function me()
    {
        try {
            return response()->json([
                'status' => true,
                'message' => "User fetched successfully",
                'data' => auth()->user()->only([
                    'id', 
                    'uuid', 
                    'name', 
                    'email', 
                    'phone', 
                    'username', 
                    'address',
                    'email_verified_at', 
                    'created_at', 
                    'updated_at'
                ], 200)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error, try again letter",
            ], 500);
        }
    }

     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Get(
     *     path="/user/company",
     *     summary="Get user company",
     *     description="Get user company",
     *     operationId="getUserCompany",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="company", type="object", example="{}"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized"),
     *         ),
     *     ),
     * )
     */

    public function company()
    {
        $user = auth()->user();
        $company = Company::find($user->company_id);

        try {
            return response()->json([
                'status' => true,
                'message' => "Company fetched successfully",
                'data' =>$company
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Internal server error, try again letter",
            ], 500);
        }
    }

    

    /** Update my profile
     * @OA\Put(
     *  path="/user/update_profile",
     *  summary="Update my profile",
     *  tags={"User"},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"name","email","phone","username","password"},
     *        @OA\Property(property="name", type="string", format="name", example="John Doe"),
     *          @OA\Property(property="email", type="string", format="email", example="example@email.com"),
     *          @OA\Property(property="phone", type="string", format="phone", example="1234567890"),
     *          @OA\Property(property="username", type="string", format="username", example="johndoe"),
     *          @OA\Property(property="password", type="string", format="password", example="password"),
     *    )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Profile updated successfully",
     * @OA\JsonContent(
     *    @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="User updated successfully"),
     * ),
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
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();


           
        try
        {
            //Check if password is equals to user password 
            if(!Hash::check($request->password, $user->password)){
                 return response()->json([
                    'status' => false,
                    'message'=> 'You entered a wrong password!'
                ], 401);
            }


            $updated = $user->update($request->only("name","email","username","phone"));

            return response()->json([
                'status' => true,
                'message' => 'Profile updated',
            ]);



        }catch(Exception $e){
             return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
    /** Update my profile
     * @OA\Put(
     *  path="/user/update_password",
     *  summary="Update my password",
     *  tags={"User"},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"current_password","new_password","confirm_password"},
     *        @OA\Property(property="current_password", type="string", format="password"),
     *          @OA\Property(property="new_password", type="string", format="password"),
     *          @OA\Property(property="new_password_confirmation", type="string", format="password"),
     *    )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Password updated successfully",
     * @OA\JsonContent(
     *    @OA\Property(property="success", type="boolean", example="true"),
     * @OA\Property(property="message", type="string", example="Password updated successfully"),
     * ),
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
    public function updatePassword(Request $request)
     {
            try {
            $user = auth()->user();

                // Validate request
                $request->validate([
                    'current_password' => 'required|string',
                    'new_password' => 'required|string|min:6|confirmed',
                ]);

                // Check if current password is correct
                if (!Hash::check($request->current_password,$user->password)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Current password is incorrect'
                    ], 400);
                }

                // Update the user's password
            $user->password = bcrypt($request->new_password);
            $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Password updated successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Server error', $e->getMessage(),
                ], 500);
            }
    }

        /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Post(
     *     path="/user/logout",
     *     summary="Logout",
     *     description="Logout",
     *     operationId="logout",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized"),
     *         ),
     *     ),
     * )
     */

    public function logout()
    {
        try {
            auth()->logout();
    
            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out'
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Internal server error, try again letter'
            ], 500);
        }
    }
}
