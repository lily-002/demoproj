<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOutgoingDeliveryNoteRequestCall extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();
        $rules = [
            'sender_company' => ['required', 'string'],
            'sender_company_vkn' => ['required','string'],
            'sender_company_mailbox' => ['required','string'],
            'customer_name' => ['required', 'string'],
            'customer_tax_number' => ['required', 'string'],
            'gib_dispatch_type' => ['required', 'string'],
            'dispatch_date' => ['required'],
            'dispatch_id' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'gib_post_box_email' => ['required', 'string'],
            'received_date' => ['required'],
            'response_date' => ['required'],
            'send_date' => ['required'],
            'portal_status' => ['sometimes'],
            'connector_status' => ['sometimes'],
            'last_update_user' => ['sometimes', 'string'],
        ];

        if ($user->hasRole('admin')) {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }

        return $rules;
    }
}
