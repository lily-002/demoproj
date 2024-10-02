<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactSubmissionMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    public function __construct()
    {
        // $this->middleware(
        //     ['auth:api', 'role:admin'], 
        //     ['except' => ['store']]
        // );
    }

    /**
     * Display a listing of the contact.
     *
     * @OA\Get(
     *     path="/admin/contacts",
     *     summary="Get all contacts",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit the number of results",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contacts retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function index(Contact $contact, $limit = 10)
    {
        try {
            $contacts = $contact->latest()->paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Contacts retrieved',
                'data' => $contacts
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created contact in storage.
     *
     * @OA\Post(
     *     path="/contacts",
     *     summary="Create a new contact",
     *     tags={"Contacts"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Contact data",
     *         @OA\JsonContent(
     *             required={"name", "email", "message"},
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="phone_number", type="string", example="123-456-7890"),
     *             @OA\Property(property="message", type="string", example="Your message here"),
     *             @OA\Property(property="become_partner", type="boolean", example="true")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function store(StoreContactRequest $request, Contact $contact)
    {
        try {
            $data = $request->validated();
            $contact->create($data);

            Mail::to($data['email'])->send(
                new ContactSubmissionMail($contact)
            );

            return response()->json([
                'status' => true,
                'message' => 'Thank you for your message. It has been sent.',
                'data' => $data
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified contact.
     *
     * @OA\Get(
     *     path="/admin/contacts/{id}",
     *     summary="Get a specific contact",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the contact to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $contact = Contact::find($id);
            return response()->json([
                'status' => true,
                'message' => 'Contact retrieved',
                'data' => $contact
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, $id)
    {
        try {
            $contact = Contact::find($id);
            $contact->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Contact updated',
                'data' => $contact
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified contact from storage.
     *
     * @OA\Delete(
     *     path="/admin/contacts/{id}",
     *     summary="Delete a contact",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="contact",
     *         in="path",
     *         description="ID of the contact to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $contact = Contact::find($id);
            $contact->delete();
            return response()->json([
                'status' => true,
                'message' => 'Contact deleted',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occured ' . $e->getMessage()
            ], 500);
        }
    }
}
