<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVenueRequest extends FormRequest
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
            'name' => [
                'required'
            ],
            'tag' => [
                'nullable'
            ],
            'description' => [
                'nullable'
            ],
            'street' => [
                'required'
            ],
            'number' => [
                'required'
            ],
            'zip' => [
                'required'
            ],
            'city' => [
                'required'
            ],
            'website' => [
                'nullable'
            ]
        ];
    }
}
