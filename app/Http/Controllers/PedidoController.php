<?php

namespace App\Http\Controllers;

use App\CarrinhoCompras;
use App\Models\Endereco;
use App\Models\Forma_de_pagamento;
use App\Models\Item;
use App\Models\Pedido;

use App\Http\Requests\StorePedidoRequest;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::where("id_usuario", auth()->user()->id)->get()->all();

        return view("site.pedidos", compact("pedidos"));
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
    public function store(StorePedidoRequest $request)
    {
        $data = $request->validated();

        if ($data['forma'] == "entrega") {
            $date = session()->get("shipping_date");
            $id_endereco = Endereco::whereId($data['endereco_entrega'])->where("id_usuario", auth()->user()->id)->get()->first()->id;
        } else if($data['forma'] == "retirada") {
            $date = $data['date'];
            $id_endereco = Endereco::whereId($data['endereco_retirada'])->where("id_usuario", 1)->get()->first()->id;
        }
        $id_forma_de_pagamento = Forma_de_pagamento::where("alias", $data["pagamento"])->get()->first()->id;

        $pedido_data = [
            "data" => $date,
            "entrega" => $data['forma'] == "entrega",
            "retirada" => $data['forma'] == "retirada",
            "observacao" => $data['obs'],
            "id_forma_de_pagamento" => $id_forma_de_pagamento,
            "id_endereco" => $id_endereco,
            "id_usuario" => auth()->user()->id
        ];

        if ($data['forma'] == "entrega") {
            $pedido_data['valor'] = CarrinhoCompras::getTotal() * CarrinhoCompras::getAdditional();
        } else {
            $pedido_data['valor'] = CarrinhoCompras::getTotal();
        }


        $id_pedido = Pedido::create($pedido_data)->id;

        $id_carrinho = CarrinhoCompras::getId();

        // cart -> order
        Item::where("id_carrinho", $id_carrinho)->update([
            'id_carrinho' => null,
            'id_pedido' => $id_pedido
        ]);

        return redirect()->route("site.checkout", ["id" => $id_pedido]);

        // return redirect()->route("site.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
