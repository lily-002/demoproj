<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProducerReceiptOutgoingRequest extends FormRequest
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
            'customer_name' => ['required', 'string'],
            'customer_tax_number' => ['required', 'string'],
            'producer_receipt_date' => ['required', 'datetime'],
            'mm_no' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'ettn' => ['required', 'string'],
            'gib_post_box_email' => ['required', 'string', 'email'],
            'mail_delivery_status' => ['sometimes', 'string'],
            'portal_status' => 'sometimes|string',
            'connector_status' => 'sometimes|string',
            'last_update_user' => ['required', 'string'],
        ];
         if ($user->hasRole('admin')) {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }
        
        return $rules;

    }
}
