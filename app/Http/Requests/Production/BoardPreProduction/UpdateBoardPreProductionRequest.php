<?php

namespace App\Http\Requests\Production\BoardPreProduction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardPreProductionRequest extends FormRequest
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
            'code' => 'required',
            'machine_id' => 'required',
            'staff_id' => 'required',
            // 'quantity' => 'required',
            // 'plate_up' => 'required',
            // 'plate_down' => 'required'
        ];
    }
}
