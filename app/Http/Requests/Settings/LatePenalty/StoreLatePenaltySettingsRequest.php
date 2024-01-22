<?php

namespace App\Http\Requests\Settings\LatePenalty;

use Illuminate\Foundation\Http\FormRequest;

class StoreLatePenaltySettingsRequest extends FormRequest
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
            'late_count_minutes' => 'required|numeric|min:0',
            'salary_type' => 'required',
            'rate' => 'required|numeric|min:0',
        ];
    }
}
