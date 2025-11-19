<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecuteContractOperationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // regras base
        $rules = [
            'document_number' => ['required', 'string'],
            'warranted_value' => ['required', 'numeric', 'min:0.01'],
            'negotiation_type' => ['required', 'in:OG,TC'],
            'installments_type' => ['required', 'in:single,multiple'],
        ];

        // single installment
        if ($this->installments_type === 'single') {
            $rules['single_installment_days'] = ['required', 'integer', 'min:1'];
            $rules['single_installment_interest'] = ['required', 'numeric', 'min:0'];
        }

        // multiple installments
        if ($this->installments_type === 'multiple') {
            $rules['multiple_installments_days'] = ['required', 'integer', 'in:7,14,21,28'];
            $rules['installments_amount'] = ['required', 'integer', 'min:2', 'max:36'];

            // array "installment_interest[index]" vindo do front
            $rules['installment_interest'] = ['required', 'array'];
            $rules['installment_interest.*'] = ['required', 'numeric', 'min:0'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'installment_interest.*.required' => 'Informe o percentual de cada parcela.',
        ];
    }
}
