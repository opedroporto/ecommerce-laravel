<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $produtos = Produto::with("categoria")->get()->all();
        if ($request->search) {
            $produtos = Produto::with("categoria")->where("nome", "LIKE", "%" . $request->search . "%")->paginate(5)->withQueryString();
        } else {
            $produtos = Produto::with("categoria")->paginate(5);
        }
        $categorias = Categoria::all();

        return view("admin.produtos.produtos", compact("produtos", "categorias"));
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
            return redirect()->route("admin.produtos.index");
        }
        // POST
        if($request->isMethod("post")){
            
            // validate data
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route("admin.produtos.index")
                            ->withErrors($validator)
                            ->withInput();
            }
            
            // store new produto
            $produto_data = $request->all();
            unset($produto_data['_token']);
            $produto_data['img'] = url("storage/" . $request->img->store("produtos"));
            $produto_data['slug'] = Str::slug($request->nome);
            $produto_data['id_categoria'] = $request->categoria;
            unset($produto_data['categoria']);

            $produto = Produto::create($produto_data);

            return redirect()->route("admin.produtos.index");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function showFull(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        // validate data
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route("admin.produtos.index")
                        ->withErrors($validator)
                        ->withInput();
        }

        // update produto
        $produto_data = $request->all();
        unset($produto_data['_token']);
        if (isset($produto_data['img'])) {
            $produto_data['img'] = url("storage/" . $request->img->store("produtos"));
        }
        $produto_data['slug'] = Str::slug($request->nome);
        $produto_data['id_categoria'] = $request->categoria;
        unset($produto_data['categoria']);

        Produto::whereId($produto_data['id'])->update($produto_data);

        return redirect()->route("admin.produtos.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) {

        Produto::whereId($request->id)->delete();

        return redirect()->route("admin.produtos.index");
    }

    public function destroymany(Request $request) {

        Produto::whereIn("id", $request->ids)->delete();

        return redirect()->route("admin.produtos.index");
    }
}
