<?php

namespace App\Http\Requests\ProductionStaff\Production;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductionDispatchRequest extends FormRequest
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
            'pre_production_no' => 'required',
            'dispatched_qty' => 'required',
        ];
    }
}
