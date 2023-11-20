<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Carbon\Carbon;

class UpdateProfileRequest extends FormRequest
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
            "nome" => "required|min:1|max:150",
            "sobrenome" => "required|min:1|max:150",
            "datanasc" => "required|date|before_or_equal:" . Carbon::now()->subYears(13)->format('Y-m-d'),
            "telefone" => ["required", "regex:/^\((?:[14689][1-9]|2[12478]|3[1234578]|5[1345]|7[134579])\) (?:[2-8]|9[1-9])[0-9]{3}\-[0-9]{4}$/"],
            "cpf" => ["required", "regex:/^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})$/"],
            "email" => "required|email",
            // "senha" => "required|min:8|max:255",
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
            'nome.required' => "O nome não pode estar vazio.",
            'nome.min' => "O nome não pode ser tão curto.",
            'nome.max' => "O nome não pode ser tão longo.",

            'sobrenome.required' => "O sobrenome não pode estar vazio.",
            'sobrenome.min' => "O sobrenome não pode ser tão curto.",
            'sobrenome.max' => "O sobrenome não pode ser tão longo.",

            'datanasc.required' => "A data de nascimento não pode estar vazia.",
            'datanasc.before_or_equal' => "É necessário ter mais de 13 anos.",
            'datanasc.date' => "A data deve estar em um formato válido.",
            
            'telefone.required' => "O telefone não pode estar vazio.",
            'telefone.regex' => "O telefone deve estar em um formato válido.",

            'cpf.required' => "O CPF não pode estar vazio.",
            'cpf.regex' => "O CPF deve estar em um formato válido.",

            'email.required' => "O e-mail não pode estar vazio.",
            'email.email' => "O e-mail deve estar em um formato válido.",

            // 'senha.required' => "A senha não pode estar vazia.",
            // 'senha.min' => "A senha deve ser maior que 8 caracteres.",
            // 'senha.max' => "A senha não pode ser maior que 255 caracteres.",
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
