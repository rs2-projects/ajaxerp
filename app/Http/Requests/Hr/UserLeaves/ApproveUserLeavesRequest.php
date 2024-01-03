<?php

namespace App\Http\Requests\Hr\UserLeaves;

use Illuminate\Foundation\Http\FormRequest;

class ApproveUserLeavesRequest extends FormRequest
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
            'start_date' => 'required',
            'end_date' => 'required',
            'number_of_days' => 'required|min:1|numeric',
        ];
    }
}
