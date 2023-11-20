<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Usuario;

class AdminUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $produtos = Produto::with("categoria")->get()->all();
        if ($request->search) {
            $usuarios = Usuario::with("enderecos")->where("nome", "LIKE", "%" . $request->search . "%")->paginate(5)->withQueryString();
        } elseif ($request->id) {
            $usuarios = Usuario::with("enderecos")->where("id", $request->id)->paginate(5)->withQueryString();
        } else {
            $usuarios = Usuario::with("enderecos")->paginate(5);
        }

        return view("admin.usuarios.usuarios", compact("usuarios"));
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
        // GET
        if($request->isMethod("get")){
            return redirect()->route("admin.usuarios.index");
        }
        // POST
        if($request->isMethod("post")){
            
            // validate data
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route("admin.usuarios.index")
                            ->withErrors($validator)
                            ->withInput();
            }
            
            // store new produto
            // $usuario_data = $validator->validated();
            $usuario_data = $request->all();
            unset($usuario_data['_token']);
            $usuario_data['role'] = $usuario_data['cargo'];
            unset($usuario_data['cargo']);
            $usuario_data['tel'] = $usuario_data['telefone'];
            unset($usuario_data['telefone']);
            $usuario_data['dtnasc'] = $usuario_data['datanasc'];
            unset($usuario_data['datanasc']);
            $usuario_data['senha'] = bcrypt($usuario_data['senha']);

            $usuario = Usuario::create($usuario_data);
            event(new Registered($usuario)); // dispatch event

            return redirect()->route("admin.usuarios.index");
        }
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
    public function update(Request $request)
    {
        // validate data
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route("admin.usuarios.index")
                        ->withErrors($validator)
                        ->withInput();
        }

        // update produto
        // $usuario_data = $validator->validated();
        $usuario_data = $request->all();
        unset($usuario_data['_token']);
        $usuario_data['role'] = $usuario_data['cargo'];
        unset($usuario_data['cargo']);
        $usuario_data['tel'] = $usuario_data['telefone'];
        unset($usuario_data['telefone']);
        $usuario_data['dtnasc'] = $usuario_data['datanasc'];
        unset($usuario_data['datanasc']);

        // 1 admin
        if ($usuario_data['id'] == 1) {
            $usuario_data['role'] = 1;
        }

        Usuario::whereId($usuario_data['id'])->update($usuario_data);

        return redirect()->route("admin.usuarios.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Usuario::whereNot("id", 1)->whereId($request->id)->delete();

        return redirect()->route("admin.usuarios.index");
    }

    public function destroymany(Request $request)
    {
        Usuario::whereNot("id", 1)->whereIn("id", $request->ids)->delete();

        return redirect()->route("admin.usuarios.index");
    }
}
