<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
        $rules = [
            'token' => 'required',
            'email' => 'required|email',
            'senha' => 'required|min:8|confirmed',
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'token.required' => "Inválido. Confira o link de redefinação e tente novamente.",
            'email.required' => "O e-mail não pode estar vazio.",
            'email.email' => "O e-mail deve estar em um formato válido.",
            'senha.required' => "A senha não pode estar vazia.",
            'senha.min' => "A senha deve ser maior que 8 caracteres.",
            'senha.confirmed' => "As senhas devem ser iguais.",
        ];


    }
}
