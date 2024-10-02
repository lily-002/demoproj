<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEInvoiceRequest extends FormRequest
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
            'invoice_uuid' => 'required',
            'invoice_date' => 'required',
            'invoice_date_time' => 'required',
            'invoice_id' => 'required',
            'receiver' => 'required',
            'receiver_tax_number' => 'required',
            'receiver_gib_postbox' => 'required',
            'receiver_country' => 'required',
            'total_products_services' => 'required',
            'total_discounts' => 'required',
            'total_increase' => 'required',
            'total_0015_vat' => 'required',
            'total_taxes' => 'required',
            'bottom_total_discount_rate' => 'required',
            'invoice_send_type_id' => 'required',
            'invoice_type_id' => 'required',
            'invoice_scenario_id' => 'required',
            'invoice_currency_id' => 'required',
        ];
    }
}
