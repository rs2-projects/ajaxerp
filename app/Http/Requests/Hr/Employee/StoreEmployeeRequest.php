<?php

namespace App\Http\Requests\Hr\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'email' => 'required|email',
//            'phone' => 'required',
//            'password' => 'required|min:6',
//            'joining_date' => 'required',
//            'designation_id' => 'required',
//            'department_id' => 'required',
        ];
    }
}
