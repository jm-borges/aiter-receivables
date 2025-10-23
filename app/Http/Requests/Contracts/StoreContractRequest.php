<?php

namespace App\Http\Requests\Contracts;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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
            'client_id' => 'required|exists:business_partners,id',
            'supplier_id' => 'required|exists:business_partners,id',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'acquirers' => 'array',
            'acquirers.*' => 'exists:business_partners,id',
            'payment_arrangements' => 'array',
            'payment_arrangements.*' => 'exists:payment_arrangements,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Add your custom error messages here
        ];
    }
}
