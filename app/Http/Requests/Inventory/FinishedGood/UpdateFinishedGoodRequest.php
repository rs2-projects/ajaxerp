<?php

namespace App\Http\Requests\Inventory\FinishedGood;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinishedGoodRequest extends FormRequest
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
            'finished_goods_category_id' => 'required',
            'warehouse_id' => 'required',
            'sections' => 'required|array',
            'racks' => 'required|array',
        ];
    }
}
