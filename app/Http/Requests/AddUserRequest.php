<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'phone' => 'numeric|required|unique:users|min:10',
            'mobile' => 'numeric|min:10',
            'username' => 'string|required|unique:users|min:6',
            'password' => 'required|min:6',
            'notification_einvoice' => 'boolean',
            'notification_edispatch' => 'boolean',
            'luca_username' => 'string|unique:users|min:3',
            'luca_member_number' => 'string',
            'luca_password' => 'string',
            'export_only' => 'boolean',
            'earchive' => 'boolean',
            'einvoice_only' => 'boolean',
            'ssi_only' => 'boolean',
            'company_id' => 'required',
        ];
    }
}
