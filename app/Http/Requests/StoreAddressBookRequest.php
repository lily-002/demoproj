<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressBookRequest extends FormRequest
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
            "supplier_name" => ["required", "string"],
            "supplier_code" => ["required", "string"],
            "tax_office" => ["nullable", "string"],
            "tax_number" => ["required", "string"],
            "payment_method_id" => ["nullable", "exists:payment_methods,id"],
            "payment_channel" => ["nullable", "string"],
            "payment_account_number" => ["nullable", "string"],
            "country" => ["nullable", "string"],
            "city" => ["nullable", "string"],
            "county" => ["nullable", "string"],
            "post_code" => ["nullable", "string"],
            "phone_number" => ["nullable", "string"],
            "address" => ["nullable", "string"],
            "mobile_phone_notification" => ["nullable", "string"],
            "outgoing_einvoice_sms_notification" => ["nullable", "boolean"],
            "sent_sms_earchive_invoice" => ["nullable", "boolean"],
            "sent_email_earchive_invoice" => ["nullable", "boolean"],
            "email" => ["nullable", "string"],
            "web_url" => ["nullable", "string"],
            "gib_registration_date" => ["nullable", "string"],
            "gib_receiver_alias" => ["nullable", "string"],
            "gib_mailbox_label" => ["nullable", "string"],
        ];
    }
}
