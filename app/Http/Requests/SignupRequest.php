<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            "nome" => "required",
            "sobrenome" => "required",
            "datanasc" => "required",
            "telefone" => "required",
            "cpf" => "required",
            "email" => "required",
            "senha" => "required",

            "end_cep" => "required",
            "end_rua" => "required",
            "end_num" => "required",
            "end_bairro" => "required",
            "end_cidade" => "required",
            "end_uf" => "required|max:2",
            "end_complemento" => "",
        ];
    }
}
