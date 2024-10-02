<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressBookRequest;
use App\Http\Requests\UpdateAddressBookRequest;
use App\Models\AddressBook;
use Illuminate\Http\Request;

class AddressBookController extends Controller
{
    // Get all address books
    /**
     * @OA\Get(
     *    path="/user/address-books",
     *   summary="Get all address books",
     *  description="Get all address books",
     * operationId="getAllAddressBooks",
     * tags={"Address Books"},
     * @OA\Response(
     *   response=200,
     *  description="Address books fetched successfully",
     * @OA\JsonContent(
     *  @OA\Property(property="status", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Address books fetched successfully"),
     * )
     * ),
     * @OA\Response(
     *  response=500,
     * description="Failed to fetch address books",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Failed to fetch address books"),
     * )
     * )
     * )
     * 
     */
    public function getAll($limit = 10)
    {
        try {
            $addressBooks = AddressBook::paginate($limit);
            return response()->json([
                'status' => true,
                'message' => 'Address books fetched successfully',
                'data' => $addressBooks,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch address books',
            ],500);
        }
    }

    // Get address book by id
    /**
     * @OA\Get(
     *   path="/user/address-books/{id}",
     *  summary="Get address book by id",
     * description="Get address book by id",
     * operationId="getByIdAddressBooks",
     * tags={"Address Books"},
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="ID of address book",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Address book fetched successfully",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Address book fetched successfully"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Address book not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Address book not found"),
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Failed to fetch address book",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Failed to fetch address book"),
     * )
     * )
     * )
     * 
     * 
     */
    public function getById($id)
    {
        try {
            $addressBook = AddressBook::find($id);
            if ($addressBook) {
                return response()->json([
                    'status' => true,
                    'message' => 'Address book fetched successfully',
                    'data' => $addressBook,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Address book not found',
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch address book',
            ],500);
        }
    }

    // Create new address book
    /**
     * @OA\Post(
     * path="/user/address-books",
     * summary="Create new address book",
     * description="Create new address book",
     * operationId="createAddressBooks",
     * tags={"Address Books"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="supplier_name", type="string", example="Supplier Name"),
     * @OA\Property(property="supplier_code", type="string", example="Supplier Code"),
     * @OA\Property(property="tax_office", type="string", example="Tax Office"),
     * @OA\Property(property="tax_number", type="string", example="Tax Number"),
     * @OA\Property(property="payment_method_id", type="integer", example=1),
     * @OA\Property(property="payment_channel", type="string", example="Payment Channel"),
     * @OA\Property(property="payment_account_number", type="string", example="Payment Account Number"),
     * @OA\Property(property="country", type="string", example="Country"),
     * @OA\Property(property="city", type="string", example="City"),
     * @OA\Property(property="county", type="string", example="County"),
     * @OA\Property(property="post_code", type="string", example="Post Code"),
     * @OA\Property(property="phone_number", type="string", example="Phone Number"),
     * @OA\Property(property="address", type="string", example="Address"),
     * @OA\Property(property="mobile_phone_notification", type="string", example="Mobile Phone Notification"),
     * @OA\Property(property="outgoing_einvoice_sms_notification", type="boolean", example=true),
     * @OA\Property(property="sent_sms_earchive_invoice", type="boolean", example=true),
     * @OA\Property(property="sent_email_earchive_invoice", type="boolean", example=true),
     * @OA\Property(property="email", type="string", example="Email"),
     * @OA\Property(property="web_url", type="string", example="Web Url"),
     * @OA\Property(property="gib_registration_date", type="string", example="Gib Registration Date"),
     * @OA\Property(property="gib_receiver_alias", type="string", example="Gib Receiver Alias"),
     * @OA\Property(property="gib_mailbox_label", type="string", example="Gib Mailbox Label"),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Address book created successfully",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Address book created successfully"),
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Failed to create address book",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Failed to create address book"),
     * )
     * )
     * )
     */

    public function create(StoreAddressBookRequest $request)
    {
        try {
            $addressBook = AddressBook::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Address book created successfully',
                'data' => $addressBook,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create address book',
            ],500);
        }
    }

    // Update address book by id
    /**
     * @OA\Put(
     * path="/user/address-books/{id}",
     * summary="Update address book by id",
     * description="Update address book by id",
     * operationId="update",
     * tags={"Address Books"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of address book",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="supplier_name", type="string", example="Supplier Name"),
     * @OA\Property(property="supplier_code", type="string", example="Supplier Code"),
     * @OA\Property(property="tax_office", type="string", example="Tax Office"),
     * @OA\Property(property="tax_number", type="string", example="Tax Number"),
     * @OA\Property(property="payment_method_id", type="integer", example=1),
     * @OA\Property(property="payment_channel", type="string", example="Payment Channel"),
     * @OA\Property(property="payment_account_number", type="string", example="Payment Account Number"),
     * @OA\Property(property="country", type="string", example="Country"),
     * @OA\Property(property="city", type="string", example="City"),
     * @OA\Property(property="county", type="string", example="County"),
     * @OA\Property(property="post_code", type="string", example="Post Code"),
     * @OA\Property(property="phone_number", type="string", example="Phone Number"),
     * @OA\Property(property="address", type="string", example="Address"),
     * @OA\Property(property="mobile_phone_notification", type="string", example="Mobile Phone Notification"),
     * @OA\Property(property="outgoing_einvoice_sms_notification", type="boolean", example=true),
     * @OA\Property(property="sent_sms_earchive_invoice", type="boolean", example=true),
     * @OA\Property(property="sent_email_earchive_invoice", type="boolean", example=true),
     * @OA\Property(property="email", type="string", example="Email"),
     * @OA\Property(property="web_url", type="string", example="Web Url"),
     * @OA\Property(property="gib_registration_date", type="string", example="Gib Registration Date"),
     * @OA\Property(property="gib_receiver_alias", type="string", example="Gib Receiver Alias"),
     * @OA\Property(property="gib_mailbox_label", type="string", example="Gib Mailbox Label"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Address book updated successfully",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Address book updated successfully"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Address book not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Address book not found"),
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Failed to update address book",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Failed to update address book"),
     * )
     * )
     * )
     * 
     */
    public function update(UpdateAddressBookRequest $request, $id)
    {
        try {
            $addressBook = AddressBook::find($id);
            if ($addressBook) {
                $addressBook->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Address book updated successfully',
                    'data' => $addressBook,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Address book not found',
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update address book',
            ],500);
        }
    }

    //Delete address book by id
    /**
     * @OA\Delete(
     * path="/user/address-books/{id}",
     * summary="Delete address book by id",
     * description="Delete address book by id",
     * operationId="delete",
     * tags={"Address Books"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of address book",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Address book deleted successfully",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Address book deleted successfully"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Address book not found",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Address book not found"),
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Failed to delete address book",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="boolean", example=false),
     * @OA\Property(property="message", type="string", example="Failed to delete address book"),
     * )
     * )
     * )
     * 
     */
    public function delete($id)
    {
        try {
            $addressBook = AddressBook::find($id);
            if ($addressBook) {
                $addressBook->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Address book deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Address book not found',
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete address book',
            ],500);
        }
    }

}
