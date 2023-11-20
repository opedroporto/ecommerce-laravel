<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\SendResetLinkRequest;
use App\Http\Requests\ResetPasswordRequest;

use App\Models\Usuario;

class PasswordController extends Controller
{
    public function reset1() {
        return view('password.resetarsenha');
    }

    public function reset2(SendResetLinkRequest $request) {
        // $request->validate(['email' => 'required|email']);

        $request = $request->validated();

        $status = Password::sendResetLink(
            ['email' => $request['email']]
        );

        return redirect()->back()->with(["success_msg" => "Link de redefinição de senha enviado! Confira a caixa de entrada do seu e-mail."]);
     
        // return $status === Password::RESET_LINK_SENT
        //             ? back()->with(['status' => __($status)])
        //             : back()->withErrors(['email' => __($status)]);
    }

    public function reset3(string $token) {
        return view('password.resetarsenha3', ['token' => $token]);
    }

    public function reset4(ResetPasswordRequest $request) {
        // $request->validate([
        //     'token' => 'required',
        //     'email' => 'required|email',
        //     'senha' => 'required|min:8|confirmed',
        // ]);

        $request = $request->validated();

        $updatePassword = DB::table("password_reset_tokens")
            ->where([
                "email" => $request['email'],
                // "token" => $request->token // FIX IT LATER
            ])->first();

        if (!$updatePassword) {
            return redirect()->back()->withErrors(["msg" => "Dados Inválido. Confira-os e tente novamente."]);
        }

        Usuario::where("email", $request['email'])->update(["senha" => bcrypt($request['senha'])]);

        DB::table("password_reset_tokens")->where(["email" => $request['email']])->delete();

        return redirect()->route("site.index")->with(["login_needed" => true]);
    }
}
