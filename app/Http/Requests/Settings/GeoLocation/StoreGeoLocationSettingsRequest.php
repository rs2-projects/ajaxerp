<?php

namespace App\Http\Requests\Settings\GeoLocation;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeoLocationSettingsRequest extends FormRequest
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
            'title' => 'required',
            'location_data' => 'required',
        ];
    }
}
