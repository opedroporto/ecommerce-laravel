<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Item;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $pedido_data = [
            "valor" => \Cart::getTotal(),
            "id_usuario" => auth()->user()->id
        ];

        $pedido = Pedido::create($pedido_data);

        $items = \Cart::getContent();
        $new_items = [];
        foreach ($items as $item) {
            $item_data = [
                "id_pedido" => $pedido->id,
                "nome" => $item->name,
                "valor" => $item->price,
                "quantidade" => $item->quantity,
                "id_produto" => $item->id
            ];
            $new_items[] = Item::create($item_data);
        }

        \Cart::clear();

        return redirect()->route("site.index");
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
