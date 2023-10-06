<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArtistRequest extends FormRequest
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
            'description' => [
                'nullable'
            ],
            'spotify' => [
                'nullable',
                'url'
            ],
            'soundcloud' => [
                'nullable',
                'url'
            ],
            'youtube' => [
                'nullable',
                'url'
            ],
            'amazon_music' => [
                'nullable',
                'url'
            ],
            'apple_music' => [
                'nullable',
                'url'
            ],
            'website' => [
                'nullable',
                'url'
            ]
        ];
    }
}
