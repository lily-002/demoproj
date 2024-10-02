<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateEledgerRequest extends FormRequest
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
            'account_name' => ['required', 'string'],
            'transaction_type_id' => ['required', 'numeric', 'exists:eledger_transaction_types,id'],
            'amount' => ['required', 'numeric'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'transaction_date' => ['required'],
            'description' => ['required', 'string'],
            'reference_number' => ['sometimes', 'string'],
            'category_id' => ['required', 'numeric', 'exists:eledger_categories,id'],
            'attachment_url' => ['sometimes', 'string'],
            'tax_info_id' => ['sometimes', 'numeric', 'exists:eledger_categories,id'],
            'tax_amount' => ['sometimes', 'numeric'],
            'payment_method_id' => ['nullable', 'numeric', 'exists:payment_methods,id'],
            'payer_name' => ['sometimes', 'string'],
            'payer_id_number' => ['sometimes', 'string'],
            'payer_id_number' => ['sometimes', 'string'],
            'status_id' => ['required', 'numeric', 'exists:eledger_statuses,id'],
            'file' => ['sometimes', 'image','mimes:jpg,jpeg,png|max:2048'] // Validate image if provided
        ];

        if ($user->hasRole('admin')) {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }

        return $rules;
    }
}
