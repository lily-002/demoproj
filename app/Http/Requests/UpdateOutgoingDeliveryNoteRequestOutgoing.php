<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateOutgoingDeliveryNoteRequestOutgoing extends FormRequest
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
        // Get the authenticated user
        $user = Auth::user();

        // Define base rules
        $rules = [
            'customer_name' => ['required', 'string'],
            'customer_tax_number' => ['required', 'string'],
            'gib_dispatch_type' => ['required', 'string'],
            'supplier_code' => ['required', 'string'],
            'dispatch_date' => ['required', 'date'],
            'dispatch_id' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'gib_post_box_email' => ['required', 'string'],
            'received_date' => ['required', 'date'],
            'response_date' => ['required', 'date'],
            'portal_status' => ['sometimes'],
            'last_update_user' => ['required', 'string']
        ];

        // Conditionally add rules based on user role   
        if ($user->hasRole('admin')) {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }

        return $rules;
    }
}
