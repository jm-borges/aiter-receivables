<?php

namespace App\Http\Requests\Attachments;

use Illuminate\Foundation\Http\FormRequest;

class AddAttachmentRequest extends FormRequest
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
            'model' => 'required|string',
            'model_id' => 'required|string',
            'file' => 'required|file', // Verifica se um arquivo está presente
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
            'model.required' => 'O campo modelo é obrigatório.',
            'model.string' => 'O campo modelo deve ser uma string.',
            'model_id.required' => 'O campo ID do modelo é obrigatório.',
            'model_id.string' => 'O campo ID do modelo deve ser uma string.',
            'file.required' => 'O campo arquivo é obrigatório.',
            'file.file' => 'O campo arquivo deve ser um arquivo válido.',
        ];
    }
}
