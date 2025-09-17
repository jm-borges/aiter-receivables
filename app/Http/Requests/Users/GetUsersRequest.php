<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class GetUsersRequest extends FormRequest
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
            'user_ids' => 'array|nullable',
            //  'user_ids.*' => 'string|exists:users,id',
            'shift_ids' => 'array|nullable',
            //   'shift_ids.*' => 'string|exists:shifts,id',
            'position_ids' => 'array|nullable',
            //    'position_ids.*' => 'string|exists:positions,id',
            'department_ids' => 'array|nullable',
            //   'department_ids.*' => 'string|exists:departments,id',
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
            'user_ids.array' => 'O campo user_ids deve ser um array.',
            'user_ids.nullable' => 'O campo user_ids é opcional.',
            'user_ids.*.string' => 'Cada ID de usuário deve ser uma string.',
            'user_ids.*.exists' => 'O ID de usuário fornecido não existe.',

            'shift_ids.array' => 'O campo shift_ids deve ser um array.',
            'shift_ids.nullable' => 'O campo shift_ids é opcional.',
            'shift_ids.*.string' => 'Cada ID de turno deve ser uma string.',
            'shift_ids.*.exists' => 'O ID de turno fornecido não existe.',

            'position_ids.array' => 'O campo position_ids deve ser um array.',
            'position_ids.nullable' => 'O campo position_ids é opcional.',
            'position_ids.*.string' => 'Cada ID de posição deve ser uma string.',
            'position_ids.*.exists' => 'O ID de posição fornecido não existe.',

            'department_ids.array' => 'O campo department_ids deve ser um array.',
            'department_ids.nullable' => 'O campo department_ids é opcional.',
            'department_ids.*.string' => 'Cada ID de departamento deve ser uma string.',
            'department_ids.*.exists' => 'O ID de departamento fornecido não existe.',
        ];
    }
}
