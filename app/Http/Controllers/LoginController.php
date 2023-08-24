<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;

use App\Models\Endereco;
use App\Models\User;
// use App\Models\Carrinho;

class LoginController extends Controller
{
    public function login(LoginRequest $request) {
        
        if(!empty($request->email)) {
            $field_type = "email";
        } else {
            $field_type = "cpf";
        }
        
        $credenciais = $request->validated();

        $cpf_email = $credenciais[$field_type];
        $senha = $credenciais['senha'];

        if(Auth::attempt([$field_type => $cpf_email, "password" => $senha], $request->remember)) {
            $request->session()->regenerate();

            // Carrinho::savetodatabase();

            return redirect()->back();
        } else {;
            return redirect()->back()->with("erro", "E-mail ou senha inválida.");
        }

    }

    public function signup(SignupRequest $request) {

        $data = $request->validated();

        $user_data = [
            "nome" => $data["nome"],
            "sobrenome" => $data["sobrenome"],
            "email" => $data["email"],
            "senha" => bcrypt($data["senha"]),
            "remember_token" => Str::random(10),
            "cpf" => $data["sobrenome"],
            "tel" => $data["telefone"],
            "dtnasc" => $data["datanasc"]
        ];

        $user = User::create($user_data);

        $end_data = [
            "cep" => $data["end_cep"],
            "rua" => $data["end_rua"],
            "num" => $data["end_num"],
            "bairro" => $data["end_bairro"],
            "cidade" => $data["end_cidade"],
            "uf" => $data["end_uf"],
            "complemento" => $data["end_complemento"],
            "id_usuario" => $user->id
        ];

        $end = Endereco::create($end_data);

        event(new Registered($user)); // dispatch event

        // login
        Auth::login($user);

        // Carrinho::savetodatabase();

        // redirect
        return redirect(route("site.index"));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route("site.index"));
    }

}
