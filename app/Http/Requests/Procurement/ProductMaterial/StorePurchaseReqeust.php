<?php

namespace App\Http\Requests\Procurement\ProductMaterial;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseReqeust extends FormRequest
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
            'supplier_id' => 'required|integer',
            'purchase_date' => 'required|date',
            'estimated_delivery_date' => 'required|date',
            'batch_number' => 'required|string',

        ];
    }
}
