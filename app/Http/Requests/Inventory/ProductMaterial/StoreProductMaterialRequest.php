<?php

namespace App\Http\Requests\Inventory\ProductMaterial;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductMaterialRequest extends FormRequest
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
            'code' => 'required',
            'product_material_category_id' => 'required',
            'unit_type' => 'required',
            'low_stock_warning' => 'required|numeric|min:0',
            'low_stock_at_least' => 'required|numeric|min:0',
            'warehouse_id' => 'required',
            'sections' => 'required|array',
            'racks' => 'required|array',
        ];
    }
}
