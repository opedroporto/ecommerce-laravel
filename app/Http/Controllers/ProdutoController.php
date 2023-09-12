<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdutoController extends Controller
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

        return view("admin.produtos.index", compact("produtos", "categorias"));
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
            // store new produto
            $produto_data = $request->all();
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
        $produto = Produto::find($id);

        return view("site.verproduto", compact("produto"));
    }

    public function showFull(string $id) {
        $produto = Produto::with("categoria")->find($id);

        return view("admin.produtos.view", compact("produto"));
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
        // TODO: validate request
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
