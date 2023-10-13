<?php

namespace App\Http\Requests;

use App\Rules\TagExists;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'type' => [
                'required',
            ],
            'weather_condition' => [
                'required'
            ],
            'start_date' => [
                'date',
                'after:yesterday',
                'required'
            ],
            'start_time' => [
                'required'
            ],
            'end_date' => [
                'date',
                'after_or_equal:start_date',
                'required'
            ],
            'end_time' => [
                'required'
            ],
            'genre' => [
                'required',
                'exists:genres,name'
            ],
            'minimum_age' => [
                'required'
            ],
            'presale_available' => [
            ],
            'presale_link' => [
                'required_if:presale_available,on',
            ],
            'box_office_available' => [
            ],
            'box_office_price' => [
                'required_if:box_office_available,on'
            ],
            'facebook_event' => [
                'nullable'
            ],
            'organizer_profile_tag' => [
                'required',
                new TagExists(),
            ],
            'venue_registered' => [
                'nullable'
            ],
            'venue' => [
                'required_with:venue_registered',
                'exists:venues,tag'
            ],
            'venue_name' => [
                'nullable'
            ],
            'street' => [
                'nullable'
            ],
            'number' => [
                'nullable'
            ],
            'zip' => [
                'nullable'
            ],
            'city' => [
                'required_without:venue_registered'
            ],
            'oneway' => [
            ],
            'registered_artists_tags' => [
                'nullable'
            ],
            'unregistered_artists' => [
                'nullable'
            ]
        ];
    }
}
