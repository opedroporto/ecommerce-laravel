<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Endereco;
use App\Models\Usuario;

class AdminEnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $enderecos = Endereco::with("usuario")->where("nome", "LIKE", "%" . $request->search . "%")->paginate(5)->withQueryString();
        } else {
            $enderecos = Endereco::with("usuario")->paginate(5);
        }
        $usuarios = Usuario::all();

        return view("admin.enderecos.enderecos", compact("enderecos", "usuarios"));
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
            return redirect()->route("admin.enderecos.index");
        }
        // POST
        if($request->isMethod("post")){
            
            // validate data
            $validator = Validator::make($request->all(), [
                'rua' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route("admin.enderecos.index")
                            ->withErrors($validator)
                            ->withInput();
            }
            
            // store new produto
            // $endereco_data = $validator->validated();
            $endereco_data = $request->all();
            unset($endereco_data['_token']);

            $endereco = Endereco::create($endereco_data);

            return redirect()->route("admin.enderecos.index");
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
            'rua' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route("admin.enderecos.index")
                        ->withErrors($validator)
                        ->withInput();
        }

        // update produto
        // $endereco_data = $validator->validated();
        $endereco_data = $request->all();
        unset($endereco_data['_token']);

        Endereco::whereId($endereco_data['id'])->update($endereco_data);

        return redirect()->route("admin.enderecos.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Endereco::whereId($request->id)->delete();

        return redirect()->route("admin.enderecos.index");
    }

    public function destroymany(Request $request)
    {
        Endereco::whereIn("id", $request->ids)->delete();

        return redirect()->route("admin.enderecos.index");
    }
}
