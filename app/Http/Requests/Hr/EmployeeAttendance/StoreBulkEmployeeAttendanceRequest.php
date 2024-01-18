<?php

namespace App\Http\Requests\Hr\EmployeeAttendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreBulkEmployeeAttendanceRequest extends FormRequest
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
            'date' => 'required',
            'employee_ids' => 'required|array',
            'time_in' => 'required',
            'time_out' => 'required',
        ];
    }
}
