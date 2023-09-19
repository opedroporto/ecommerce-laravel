<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Endereco;

class getWithdrawalDateRequest extends FormRequest
{
    private $id_endereco;

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
        $rules = [];

        // $this->id_endereco = Endereco::whereId($this->get("id_end"))->where("id_usuario", auth()->user()->id)->get()->first()->id;
        // $rules['id_end'] = ["required", "regex:/^" . $this->id_endereco . "$/"]; // address rule

        return $rules;
    }

    // overload function to validate JSON
    public function all($keys = null){
        if(empty($keys)){
            return parent::json()->all();
        }

        return collect(parent::json()->all())->only($keys)->toArray();
    }
}
