<?php

namespace App\Http\Requests\Settings\LeaveType;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveTypeSettingsRequest extends FormRequest
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
            'annual_leave_days' => 'required|numeric',
            'max_leave_per_month' => 'required|numeric',
        ];
    }
}
