<?php

namespace App\Http\Controllers;

use App\Models\Forma_de_pagamento;
use Illuminate\Http\Request;

use App\Models\Produto;
use App\Models\Endereco;
use App\Models\Item;
use App\Models\Carrinho;

use App\CarrinhoCompras;

use App\Cart\CacheStorage;
use App\DatabaseStorageModel;
use App\DBStorage;

class CarrinhoController extends Controller
{
    public function lista(Request $request) {

        $items = CarrinhoCompras::getItems();
        $total = CarrinhoCompras::getTotal();

        return view("site.carrinho", compact("items", "total"));
    }

    public function add(Request $request) {
        $produto = Produto::find($request->id);

        $item_dados = [
            "nome" => $produto->nome,
            "valor" => $produto->valor,
            "quantidade" => intval($request->quantidade),
            "id_produto" => $produto->id,
            "produto" => Produto::find($produto->id)
        ];

        CarrinhoCompras::setItem($item_dados);

        return redirect()->route("site.carrinho")->with("sucesso", "Produto adicionado ao carrinho!");
    }

    public function finalizarcompra(Request $request) {
        $enderecos = Endereco::where("id_usuario", auth()->user()->id)->get();

        return view("site.finalizarcompra", compact("enderecos"));
    }
}
