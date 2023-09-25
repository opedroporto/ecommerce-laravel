<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Colecao;
use App\Models\Produto;
use App\Models\ProdutoColecao;

class AdminColecaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $colecoes = Colecao::with("produtos")->get()->all();
        if ($request->search) {
            $colecoes = Colecao::with("produtos")->where("nome", "LIKE", "%" . $request->search . "%")->paginate(5)->withQueryString();
        } else {
            $colecoes = Colecao::with("produtos")->paginate(5);
        }

        // foreach coleção
        foreach ($colecoes as $index=>$colecao) {
            // produto coleção
            $colecoes[$index]['produto_colecao'] = ProdutoColecao::where([['id_colecao', $colecao->id]])->get();
        }
        
        $produtos = Produto::all();

        return view("admin.colecoes.colecoes", compact("colecoes", "produtos"));
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
            return redirect()->route("admin.colecoes.index");
        }
        // POST
        if($request->isMethod("post")){
            
            // validate data
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route("admin.colecoes.index")
                            ->withErrors($validator)
                            ->withInput();
            }
            
            // store new colecao
            $colecao_data = $request->all();
            unset($colecao_data['_token']);
            if (isset($colecao_data['img'])) {
                $colecao_data['img'] = url("storage/" . $request->img->store("produtos"));
            }
            $colecao_data['slug'] = Str::slug($request->nome);

            $produtos = $colecao_data['produtos'];
            unset($colecao_data['produtos']);

            $colecao = Colecao::create($colecao_data);


            // merge produtos
            $novos_produtos = array();

            foreach($produtos as $produto) {
                $produto['quantidade'] = (int)$produto['quantidade'];
                // update already existing produto
                $exists = false;
                foreach($novos_produtos as $index=>$novo_produto) {
                    if ($novo_produto['id'] == $produto['id']) {
                        $novos_produtos[$index]['quantidade'] += $produto['quantidade'];
                        $exists = true;
                        break;
                    }
                }
                // new produto
                if (!$exists) {
                    array_push($novos_produtos, $produto);
                }
            }
            
            // store produto_colecao
            foreach($novos_produtos as $produto) {
                $produto_data = [
                    'id_produto' => $produto['id'],
                    'id_colecao' => $colecao['id'],
                    'quantidade' => $produto['quantidade']
                ];

                ProdutoColecao::create($produto_data);
            }

            return redirect()->route("admin.colecoes.index");
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
            return redirect()->route("admin.colecoes.index")
                        ->withErrors($validator)
                        ->withInput();
        }

        // update coleção
        $colecao_data = $request->all();
        unset($colecao_data['_token']);
        if (isset($colecao_data['img'])) {
            $colecao_data['img'] = url("storage/" . $request->img->store("produtos"));
        }
        $colecao_data['slug'] = Str::slug($request->nome);
        
        $produtos = $colecao_data['produtos'];
        unset($colecao_data['produtos']);
        Colecao::whereId($colecao_data['id'])->update($colecao_data);

        // merge produtos
        $novos_produtos = array();

        foreach($produtos as $produto) {
            $produto['quantidade'] = (int)$produto['quantidade'];
            // update already existing produto
            $exists = false;
            foreach($novos_produtos as $index=>$novo_produto) {
                if ($novo_produto['id'] == $produto['id']) {
                    $novos_produtos[$index]['quantidade'] += $produto['quantidade'];
                    $exists = true;
                    break;
                }
            }
            // new produto
            if (!$exists) {
                array_push($novos_produtos, $produto);
            }
        }

        // update produto_colecao
        ProdutoColecao::where('id_colecao', $colecao_data['id'])->delete();
        foreach($novos_produtos as $produto) {

            $produto_colecao = ProdutoColecao::updateOrCreate(
                ['id_produto' => $produto['id'], 'id_colecao' => $colecao_data['id']],
                ['quantidade' => $produto['quantidade']]
            );
        }

        return redirect()->route("admin.colecoes.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Colecao::whereId($request->id)->delete();

        return redirect()->route("admin.colecoes.index");
    }

    public function destroymany(Request $request) {

        Colecao::whereIn("id", $request->ids)->delete();

        return redirect()->route("admin.colecoes.index");
    }
}
