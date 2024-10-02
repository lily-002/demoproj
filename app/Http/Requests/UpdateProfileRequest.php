<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
        
        return [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users,email,' . $user->id,
            'phone' => 'numeric|required|unique:users,phone,' . $user->id . '|min:10',
            'username' => 'string|required|unique:users,username,' . $user->id . '|min:6',
            'password' => 'string|min:6',
        ];
    }
}
