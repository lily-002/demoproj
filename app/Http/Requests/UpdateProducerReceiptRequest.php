<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProducerReceiptRequest extends FormRequest
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
        $rules= [
            'producer_date' => ['required', 'date'],
            'producer_name' => ['required', 'string'],
            'unit_id' => ['required', 'numeric', 'exists:measurement_units,id'],
            'total_amount' => ['required', 'numeric'],
            'title' => ['required', 'string'],
            'receiver_name' => ['required', 'string'],
            'receiver_tax_number' => ['required', 'string'],
            'receiver_tax_office' => ['sometimes', 'string'],
            'sms_notification_for_earchive' => ['sometimes', 'boolean'],
            'add_to_address_book' => ['sometimes', 'boolean'],
            'buyer_country' => ['required', 'string'],
            'buyer_city' => ['sometimes', 'string'],
            'buyer_email' => ['sometimes', 'string'],
            'buyer_mobile_number' => ['sometimes', 'string'],
            'buyer_web_address' => ['sometimes', 'string'],
            'buyer_address' => ['required', 'string'],
            'total_product_services' => ['required', 'numeric'],
            'total_0003_stoppage' => ['required', 'numeric'],
            'total_taxes' => ['required', 'numeric'],
            'total_payable' => ['required', 'numeric'],
            'notes' => ['sometimes', 'string'],

            'products' => ['required', 'array'],
            'products.*.fee_reason' => ['required', 'string'],
            'products.*.quantity1' => ['required', 'integer', 'min:1'],
            'products.*.quantity2' => ['required', 'integer', 'min:1'],
            'products.*.unit_id1' => ['required', 'integer', 'exists:measurement_units,id'],
            'products.*.unit_id2' => ['required', 'integer', 'exists:measurement_units,id'],
            'products.*.price' => ['required', 'numeric', 'min:0.01'],
            'products.*.gross_amount' => ['required', 'numeric'],
            'products.*.rate' => ['required', 'numeric'],
            'products.*.amount' => ['required', 'numeric', 'min:0.01'],
            'products.*.tax_line_total' => ['required', 'numeric'],
            'products.*.payable_line' => ['required', 'numeric'],
            'products.*.product_category_id' => ['required','exists:product_categories,id']
        ];

         if ($user->hasRole('admin')) {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }
        return $rules;
    }
}
