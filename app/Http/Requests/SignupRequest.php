<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Carbon\Carbon;

class SignupRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
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
            "senha" => "required|min:8|max:255",
            
            "end_cep" => ["required", "regex:/^[0-9]{5}-[0-9]{3}$/"],
            "end_rua" => "required|min:1|max:150",
            "end_num" => "required|digits_between:1,5",
            "end_bairro" => "required|min:1|max:255",
            "end_cidade" => "required|min:1|max:255",
            "end_uf" => ["required", "regex:/^(AC|AL|AP|AM|BA|CE|DF|ES|GO|MA|MT|MS|MG|PA|PB|PR|PE|PI|RJ|RN|RS|RO|RR|SC|SP|SE|TO|BR)$/"],
            "end_complemento" => "nullable|min:1|max:255"
        ];

        // if (!empty($this->get("end_complemnto"))) {
        //     $rules["end_complemento"] = "min:1|max:255";
        // }

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

            'senha.required' => "A senha não pode estar vazia.",
            'senha.min' => "A senha deve ser maior que 8 caracteres.",
            'senha.max' => "A senha não pode ser maior que 255 caracteres.",

            'end_cep.required' => "O CEP não pode estar vazio.",
            'end_cep.regex' => "O CEP deve estar em um formato válido.",

            'end_rua.required' => "A rua não pode estar vazia.",
            'end_rua.min' => "A rua não pode ser tão curta.",
            'end_rua.max' => "A rua não pode ser tão longa.",

            'end_num.required' => "O número não pode estar vazio.",
            'end_num.digits_between' => "O número deve ser um número com no máximo 5 dígitos.",

            'end_bairro.required' => "O bairro não pode estar vazio.",
            'end_bairro.min' => "O bairro não pode ser tão curto.",
            'end_bairro.max' => "O bairro não pode ser tão longo.",

            'end_cidade.required' => "A cidade não pode estar vazia.",
            'end_cidade.min' => "A cidade não pode ser tão curta.",
            'end_cidade.max' => "A cidade não pode ser tão longa.",

            'end_uf.required' => "A UF não pode estar vazia.",
            'end_uf.regex' => "A UF deve ser uma UF válida.",

            'end_complemento.min' => "O complemento não pode ser tão curto.",
            'end_complemento.max' => "O complemento não pode ser tão longo."
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
