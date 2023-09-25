<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Categoria;

class AdminCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $produtos = Produto::with("categoria")->get()->all();
        if ($request->search) {
            $categorias = Categoria::where("nome", "LIKE", "%" . $request->search . "%")->paginate(5)->withQueryString();
        } else {
            $categorias = Categoria::paginate(5);
        }

        return view("admin.categorias.categorias", compact("categorias"));
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
            return redirect()->route("admin.categorias.index");
        }
        // POST
        if($request->isMethod("post")){
            
            // validate data
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route("admin.categorias.index")
                            ->withErrors($validator)
                            ->withInput();
            }
            
            // store new categoria
            $categoria_data = $request->all();
            unset($categoria_data['_token']);
            $categoria_data['nome'] = $request->nome;
            $categoria_data['descricao'] = $request->descricao;

            $categoria = Categoria::create($categoria_data);

            return redirect()->route("admin.categorias.index");
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
    public function edit(Request $request)
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
            return redirect()->route("admin.categorias.index")
                        ->withErrors($validator)
                        ->withInput();
        }

        // update categoria
        $categoria_data = $request->all();
        unset($categoria_data['_token']);
        $categoria_data['nome'] = $request->nome;
        $categoria_data['descricao'] = $request->descricao;

        Categoria::whereId($categoria_data['id'])->update($categoria_data);

        return redirect()->route("admin.categorias.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Categoria::whereId($request->id)->delete();

        return redirect()->route("admin.categorias.index");
    }
    public function destroymany(Request $request)
    {
        Categoria::whereIn("id", $request->ids)->delete();

        return redirect()->route("admin.categorias.index");
    }
}
