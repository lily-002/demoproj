<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProducerReceiptCallRequest extends FormRequest
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
            'sender_company_vkn' => ['required', 'string'],
            'sender_company_mailbox' => ['required', 'email', 'string'],
            'customer_name' => ['required', 'string'],
            'customer_tax_number' => ['required', 'string'],
            'mm_tarihi' => ['required', 'date'],
            'mm_no' => ['required', 'string'],
            'ettn' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'status' => ['sometimes', 'string'],
            'gib_post_box_email' => ['required', 'email', 'string'],
            'portal_status' => ['sometimes', 'string'],
            'connector_status' => ['sometimes', 'string'],
            'cancell_status' => ['sometimes', 'string'],
            'is_archive' => ['sometimes', 'boolean'],
            'last_update_user' => ['required', 'string'],
        ];
        if ($user->hasRole('admin')) {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }
        
        return $rules;
    }
}
