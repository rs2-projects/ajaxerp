<?php

namespace App\Http\Requests\Settings\BonusTypeSalary;

use Illuminate\Foundation\Http\FormRequest;

class StoreBonusTypeSalarySettingsRequest extends FormRequest
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
            'settings_bonus_type_id' => 'required',
            'settings_salary_type_id' => 'required',
            'rate_type' => 'required',
            'salary_type' => 'required_if:rate_type,==,0',
            'rate' => 'required|numeric|min:0',
        ];
    }
}
