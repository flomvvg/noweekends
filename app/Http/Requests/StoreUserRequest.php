<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'unique:users'
            ],
            'email' => [
                'email:rfc,dns',
                'required',
                'unique:users,email'],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'username.unique' => 'This username is already taken',
            'email.required' => 'E-Mail address is required',
            'email.unique' => 'E-Mail address is already in use',
        ];
    }
}
