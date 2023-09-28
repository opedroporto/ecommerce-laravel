<?php

namespace App\Http\Controllers;

use App\CarrinhoCompras;
use App\Models\Endereco;
use App\Models\FormaDePagamento;
use App\Models\Item;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Colecao;

use App\Http\Requests\StorePedidoRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stripe = new \Stripe\StripeClient(config("stripe.pk"));

        $pedidos = Pedido::where("id_usuario", auth()->user()->id)->get()->all();

        foreach($pedidos as $pedido) {
            $session_data = $stripe->checkout->sessions->retrieve(
                $pedido->session_id,
                []
            );

            // $pedido['session_data'] = $pedido_data;
            
            Pedido::whereId($pedido->id)->update([
                "session_data" => json_encode($session_data),
                "session_id" => $session_data->id,
                "uri_pagamento" => $session_data->url
            ]);
        }
        $pedidos = Pedido::with("usuario")->with("items_pedido")->with("forma_de_pagamento")->where("id_usuario", auth()->user()->id)->orderByDesc('created_at')->get()->all();
        foreach($pedidos as $pedido) {
            foreach($pedido['items_pedido'] as $item) {
                if ($item['tipo'] == "colecao") {
                    $item['produto'] = Colecao::whereId($item['id_produto'])->first();
                } elseif ($item['tipo'] == "produto") {
                    $item['produto'] = Produto::whereId($item['id_produto'])->first();
                }
            }
        }
        // $pedidos = Pedido::where("id_usuario", auth()->user()->id)->get()->all();

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
            $id_endereco = Endereco::whereId($data['endereco_entrega'])->where("id_usuario", auth()->user()->id)->get()->first()->id;
            // $date = session()->get("shipping_date" . $data['secret_token']);
            $date = getShippingDate([
                'secret_token' => $data['secret_token'],
                'id_end' => $id_endereco
            ]);
        } else if($data['forma'] == "retirada") {
            $date = $data['date'];
            $id_endereco = Endereco::whereId($data['endereco_retirada'])->where("id_usuario", 1)->get()->first()->id;
        }
        $id_forma_de_pagamento = FormaDePagamento::where("alias", $data["pagamento"])->get()->first()->id;

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
            // $pedido_data['taxa_entrega'] = session()->get("shipping_tax" . $data['secret_token']);
            $pedido_data['taxa_entrega'] = getShippingTax([
                'secret_token' => $data['secret_token'],
                'id_end' => $id_endereco
            ]);
            $pedido_data['taxa_montagem'] = CarrinhoCompras::getAdditional();
            $pedido_data['valor'] = CarrinhoCompras::getTotal() + CarrinhoCompras::getAdditional() + $pedido_data['taxa_entrega'];
        } else {
            $pedido_data['valor'] = CarrinhoCompras::getTotal();
        }

        // check stock (and reduce stock quantity)
        $items = CarrinhoCompras::getItems();
        foreach ($items as $item) {
            // type
            if ($item['tipo'] == "colecao") {
                $item['produto'] = Colecao::whereId($item['id_produto'])->first();
            } elseif ($item['tipo'] == "produto") {
                $item['produto'] = Produto::whereId($item['id_produto'])->first();
            }
            if (($item['produto']['quantidade'] - $item['quantidade']) < 0) {
                // erro
                return redirect()->back()->withErrors(['erro' => 'Não é possível continuar neste momento (possível motivo: falta de estoque)']);
            }
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
