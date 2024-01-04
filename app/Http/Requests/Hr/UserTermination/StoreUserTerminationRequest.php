<?php

namespace App\Http\Requests\Hr\UserTermination;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserTerminationRequest extends FormRequest
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
            'user_id' => 'required',
            'settings_termination_type_id' => 'required',
            'termination_date' => 'required',
        ];
    }
}
