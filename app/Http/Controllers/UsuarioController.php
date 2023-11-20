<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Usuario;

use App\Http\Requests\UpdateProfileRequest;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        //  // validate data
        //  $validator = Validator::make($request->all(), [
        //     'nome' => 'required',
        //     'sobrenome' => 'required',
        //     'email' => 'required',
        //     'cpf' => 'required',
        //     'telefone' => 'required',
        //     'datanasc' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return redirect()->route("site.perfil")
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        
        // validate
        if (isset($request->validator) && $request->validator->fails()) {
            // return response()->json($request->validator->messages(), 400);
            return redirect()->route("site.perfil")->withErrors($request->validator)->withInput();
        }
        $usuario_data = $request->validated();

        // update produto
        unset($usuario_data['_token']);
        $usuario_data['role'] = 0;
        $usuario_data['tel'] = $usuario_data['telefone'];
        unset($usuario_data['telefone']);
        $usuario_data['dtnasc'] = $usuario_data['datanasc'];
        unset($usuario_data['datanasc']);

        Usuario::whereId(auth()->user()->id)->update($usuario_data);

        return redirect()->route("site.perfil");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
