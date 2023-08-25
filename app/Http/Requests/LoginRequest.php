<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'senha' => "required|min:8|max:255",
        ];

        if (!empty($this->get("email"))) {
            $rules['email'] = "required|email";
        } else {
            $rules['cpf'] = ["required", "regex:/^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})$/"];
        }

        return $rules;
        // "email" => ["required_without:cpf", "email"],
        // "cpf" => ["required_without:email", "regex:/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})"],
        // "senha" => ["required"],
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'senha.required' => "A senha não pode estar vazia.",
            'senha.min' => "A senha deve ser maior que 8 caracteres.",
            'senha.max' => "A senha não pode ser maior que 255 caracteres.",

            'email.required' => "O e-mail não pode estar vazio.",
            'email.email' => "O e-mail deve estar em um formato válido.",
            
            'cpf.required' => "O CPF não pode estar vazio.",
            'cpf.regex' => "O CPF deve estar em um formato válido."
        ];


    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
