<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pedido;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

use App\CarrinhoCompras;


class StripeController extends Controller
{
    public function checkout(Request $request) {

        // set Stripe API key
        \Stripe\Stripe::setApiKey(config("stripe.pk"));

        // get items
        $items = Item::where("id_pedido", $request->id)->get()->all();

        // generate payment items
        $line_items = [];

        foreach ($items as $item) {
            $item_price = $item->price * 100;

            $line_items[] = [
                "price_data" => [
                    "currency" => "brl",
                    "product_data" => [
                        "name" => $item->nome
                    ],
                    "unit_amount" => $item->valor * 100    
                ],
                "quantity" => $item->quantidade
            ];
        }
        
        $pedido = Pedido::whereId($request->id)->get()->first();
        if ($pedido['entrega']) {
            // + montagem
            $line_items[] = [
                "price_data" => [
                    "currency" => "brl",
                    "product_data" => [
                        "name" => "Adicional de montagem"
                    ],
                    "unit_amount" => CarrinhoCompras::getAdditional() * 100
                ],
                "quantity" => 1
            ];
            // + entrega
            $line_items[] = [
                "price_data" => [
                    "currency" => "brl",
                    "product_data" => [
                        "name" => "Taxa de entrega"
                    ],
                    "unit_amount" => $pedido->taxa_entrega * 100
                ],
                "quantity" => 1
            ];
        }

        // create checkout session
        $session = \Stripe\Checkout\Session::create([
            "line_items" => $line_items,
            "mode" => "payment",
            "success_url" => route("site.success"),
            "cancel_url" => route("site.index")
        ]);

        // set order payment uri
        Pedido::whereId($pedido->id)->update([
            "uri_pagamento" => $session->url
        ]);

        return redirect()->away($session->url);

    }

    public function success() {
        return view("site.index");
    }

    public function webhook(Request $request) {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/custom.log'),
        ])->info('Webhook route accessed');

        $payload = json_decode($request->getContent(), true);

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/custom.log'),
        ])->info($payload);
        // Log::build([
        //     'driver' => 'single',
        //     'path' => storage_path('logs/custom.log'),
        // ])->info(implode($payload));

        // Log::debug('Webhook.');
        // Log::debug(implode($payload));

        return new Response('OK', 200);
    }
}
