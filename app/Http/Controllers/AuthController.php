<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Str; // Added for generating random string
use Illuminate\Support\Facades\Password; // Added for password reset

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register',
                'resetPassword',
                'forgotPassword'
            ]
        ]);
    }

    public function login(LoginRequest $request)
    {
        // Validate user credentials
        $credentials = $request->validated();

        try {
            // Attempt to authenticate the user and return token
            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'status' => false,
                ], 401);
            }

            return $this->respondWithToken(
                $token,
                true,
                "Login successful"
            );

        } catch (Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'status' => false,
            ], 500);
        }
    }

    // public function register(RegisterRequest $request)
    // {
    //     // Validate the incoming request data
    //     $validatedData = $request->validated();

    //     // Hash the user's password for security
    //     $validatedData['password'] = bcrypt($request->password);

    //     try {
    //         // Attempt to create a new user with the validated data
    //         $user = User::create($validatedData);

    //         $user->assignRole('admin');
    //         $token = auth()->login($user);
    //         return $this->respondWithToken(
    //             $token,
    //             true,
    //             "User registered successfully"
    //         );

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => "An error occurred",
    //         ], 500);
    //     }
    // }

    protected function respondWithToken($token, $status, $msg)
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'data' => [
                'user' => auth()->user()->only([
                    'id',
                    'uuid',
                    'name',
                    'email',
                    'phone',
                    'username',
                    'address',
                    'company_id',
                    'email_verified_at',
                    'created_at',
                    'updated_at'
                ]),
                'access_token' => $token
            ],
        ]);
    }
    public function register(RegisterRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Hash the user's password for security
        $validatedData['password'] = bcrypt($request->password);

        try {
            // Attempt to create a new user with the validated data
            $user = User::create($validatedData);

            $user->assignRole('admin');
            $token = auth()->login($user);
            return $this->respondWithToken(
                $token,
                true,
                "User registered successfully"
            );

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => "An error occurred",
            ], 500);
        }
    }


    /**
     * Send reset password email.
     *
     * @OA\Post(
     *     path="/auth/forgot-password",
     *     summary="Forgot Password",
     *     description="Send reset password email",
     *     operationId="forgotPassword",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user email",
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password reset link sent on your email id."),
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
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        //reset the password the email via api
        $status = Password::sendResetLink($request->validated());

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'status' => true,
                'message' => 'Password reset link sent successfully'
            ], 201)
            : response()->json([
                'status' => false,
                'message' => 'Internal server error, try again'
            ], 500);
    }


    /**
     * Reset user password.
     *
     * @OA\Post(
     *    path="/auth/reset-password",
     *    summary="Reset Password",
     *    description="Reset user password",
     *    operationId="resetPassword",
     *    tags={"Auth"},
     *    security={{"bearerAuth":{}}},
     *    @OA\RequestBody(
     *        required=true,
     *        description="Pass user email and new password",
     *        @OA\JsonContent(
     *            required={"email", "password", "password_confirmation", "token"},
     *            @OA\Property(property="email", type="string", format="email", example="string"),
     *            @OA\Property(property="password", type="string", format="password", example="string"),
     *            @OA\Property(property="password_confirmation", type="string", format="password", example="string"),
     *            @OA\Property(property="token", type="string", example="reset_token_from_email"),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *        @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Password reset successfully"),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *        @OA\JsonContent(
     *            @OA\Property(property="error", type="string", example="Unauthorized"),
     *        ),
     *    ),
     * )
     */

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset($request->validated(), function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();
        });

        return $status == Password::PASSWORD_RESET
            ? response()->json([
                'status' => true,
                'message' => 'Password reset successfully'
            ], 201)
            : response()->json([
                'status' => false,
                'message',
                'error' => 'Unauthorized'
            ], 401);
    }


    /**
     * Get the token array structure along with user data.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // protected function respondWithToken($token, $status, $msg)
    // {
    //     return response()->json([
    //         'status' => $status,
    //         'message' => $msg,
    //         'data' => [
    //             'user' => auth()->user()->only([
    //                 'id',
    //                 'uuid',
    //                 'name',
    //                 'email',
    //                 'phone',
    //                 'username',
    //                 'address',
    //                 'company_id',
    //                 'email_verified_at',
    //                 'created_at',
    //                 'updated_at'
    //             ]),

    //             'access_token' => $token
    //         ],
    //     ]);
    // }
}