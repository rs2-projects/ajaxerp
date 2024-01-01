<?php

namespace App\Http\Requests\Hr\SalarySet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalarySetRequest extends FormRequest
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
            'name' => 'required',
            'settings_salary_type_id' => 'required',
            'settings_overtime_type_id' => 'required',
            'settings_absent_penalty_id' => 'required',
            'settings_late_penalty_id' => 'required',
            'settings_office_time_type_id' => 'required',
            'salary_generate_type' => 'required',
        ];
    }
}
