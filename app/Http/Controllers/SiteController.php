<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produto;
use App\Models\Colecao;
use App\Models\ProdutoColecao;

class SiteController extends Controller
{
    public function index(Request $request) {
        // produtos
        if ($request->modo == "criar") {
            $produtos = Produto::all();
            return view("site.index", compact("produtos"));

        // coleções
        } else {
            $colecoes = Colecao::all();
            // produto coleção
            foreach($colecoes as $colecao) {
                $produto_colecaos = ProdutoColecao::where("id_colecao", $colecao->id)->get();
                // produtos
                $produtos = [];
                foreach($produto_colecaos as $produto_colecao) {
                    array_push($produtos, Produto::whereId($produto_colecao->id_produto)->get());
                }
                $colecao["produtos"] = $produtos;
            }

            return view("site.index", compact("colecoes"));
        }
    }
}
