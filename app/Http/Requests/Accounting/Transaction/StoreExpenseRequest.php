<?php

namespace App\Http\Requests\Accounting\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'account' => 'required',
            'category' => 'required',
            'amount' => 'required|numeric|min:1',
            'vat_tax' => 'nullable',
            'receipts' => 'nullable',
            'description' => 'nullable'
        ];
    }
}
