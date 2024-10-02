<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
        return [
            'company_name' => ['required', 'string'],
            'tax_number' => ['sometimes', 'string'],
            'tax_office' => ['sometimes', 'string'],
            'mersis_number' => ['sometimes', 'string'],
            'business_registry_number' => ['sometimes',  'string'],
            'operating_center' => ['sometimes', 'string'],
            'country' => ['sometimes', 'string'],
            'city' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'email' => ['sometimes', 'string'],
            'phone_number' => ['sometimes', 'string'],
            'website' => ['sometimes', 'string'],
            'gib_registration_data' => ['sometimes', 'string'],
            'gib_sender_alias' => ['sometimes', 'string'],
            'gib_receiver_alias' => ['sometimes', 'string'],
            'e-signature_method' => ['sometimes', 'string'],
            'date_of_last_update' => ['sometimes', 'string'],
            'last_update_user' => ['sometimes', 'string'],
        ];
    }
}
