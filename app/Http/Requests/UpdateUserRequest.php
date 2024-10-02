<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * The ID of the user being updated.
     *
     * @var int
     */
    protected $userId;

    /**
     * Create a new request instance.
     *
     * @param  int  $userId
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

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
            'email' => 'email|required|unique:users,email,' . $this->userId,
            'phone' => 'numeric|required|unique:users,phone,' . $this->userId . '|min:10',
            'username' => 'string|required|unique:users,username,' . $this->userId . '|min:6',
            'password' => 'string|min:6',
            'notification_einvoice' => 'boolean',
            'notification_edispatch' => 'boolean',
            'luca_username' => 'string|unique:users,luca_username,' . $this->userId . '|min:3',
            'luca_member_number' => 'string',
            'luca_password' => 'string|min:6',
            'export_only' => 'boolean',
            'earchive' => 'boolean',
            'einvoice_only' => 'boolean',
            'ssi_only' => 'boolean',
        ];
    }
}
