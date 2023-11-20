<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Categoria;
use App\Models\Colecao;
use App\Models\Endereco;
use App\Models\Produto;
use App\Models\ProdutoColecao;

class SiteController extends Controller
{

    public function index(Request $request) {
        // produtos
        if ($request->modo == "criar") {
            $categorias = Categoria::where('nome','!=','Genérico')->get();

            // filter by category
            if (isset($request->categoria) && $request->categoria != 0) {
                // $produtos = Produto::where("id_categoria", $request->categoria)->get();
                $produtos = Produto::where('id_categoria', $request->categoria)->whereHas('categoria', function($q){
                    $q->where('nome','!=','Genérico');
                })->get();
            } else {
                // $produtos = Produto::all();
                $produtos = Produto::whereHas('categoria', function($q){
                    $q->where('nome','!=','Genérico');
                })->get();
            }

            return view("site.index", compact("produtos", "categorias"));

        // coleções
        } else {
            $colecoes = Colecao::all();
            // produto coleção
            foreach($colecoes as $colecao) {

                // produtos
                $produto_colecaos = ProdutoColecao::where("id_colecao", $colecao->id)->get();
                $produtos = [];
                foreach($produto_colecaos as $produto_colecao) {
                    array_push($produtos, Produto::whereId($produto_colecao->id_produto)->get());
                }
                $colecao["produtos"] = $produtos;
            }

            return view("site.index", compact("colecoes"));
        }
    }

    public function sobre() {
        return view("site.sobre");
    }

    public function perfil() {
        $usuario = auth()->user();
        $enderecos = Endereco::where("id_usuario", $usuario->id)->get();
        return view("site.perfil", compact("usuario", "enderecos"));
    }
}
