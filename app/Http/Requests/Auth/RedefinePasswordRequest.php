<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RedefinePasswordRequest extends FormRequest
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
            'token' => 'required|exists:password_reset_tokens,token',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'token.required' => 'O token de redefinição é obrigatório',
            'token.exists' => 'Parece que esse link não é válido ou expirou',
            'password.required' => 'A nova senha é obrigatória',
            'password.confirmed' => 'A confirmação da senha é obrigatória',
        ];
    }
}
