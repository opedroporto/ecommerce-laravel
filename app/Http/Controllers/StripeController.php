<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pedido;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

use \Datetime;

use App\CarrinhoCompras;
use App\Models\Produto;
use App\Models\Colecao;
use App\Models\StripeEvent;

class StripeController extends Controller
{
    public function checkout(Request $request) {

        // set Stripe API key
        // \Stripe\Stripe::setApiKey(config("stripe.pk"));
        $stripe = new \Stripe\StripeClient(config("stripe.pk"));

        // get items
        $items = Item::where("id_pedido", $request->id)->get()->all();

        // generate payment items
        $line_items = [];

        foreach ($items as $item) {
            // type
            if ($item['tipo'] == "colecao") {
                $item['produto'] = Colecao::whereId($item['id_produto'])->first();
            } elseif ($item['tipo'] == "produto") {
                $item['produto'] = Produto::whereId($item['id_produto'])->first();
            }

            $item_price = $item->price * 100;

            $line_items[] = [
                "price_data" => [
                    "currency" => "brl",
                    "product_data" => [
                        "name" => $item->nome
                    ],
                    "unit_amount" => $item['produto']->valor * 100    
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

        $time = new DateTime();
        $time->modify('+30 minutes');
        $timestamp = $time->getTimestamp();
        // create checkout session
        // $session = \Stripe\Checkout\Session::create([
        //     "line_items" => $line_items,
        //     "mode" => "payment",
        //     "success_url" => route("site.getpedidos"),
        //     "cancel_url" => route("site.index"),
        //     "expires_at" => $timestamp
        // ]);
        $session = $stripe->checkout->sessions->create([
            "line_items" => $line_items,
            "mode" => "payment",
            "success_url" => route("site.getpedidos"),
            "cancel_url" => route("site.index"),
            "expires_at" => $timestamp
        ]);

        // set order payment uri
        Pedido::whereId($pedido->id)->update([
            "session_data" => json_encode($session),
            "session_id" => $session->id,
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

        $json_payload = $request->getContent();
        $payload = json_decode($json_payload, true);

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/custom.log'),
        ])->info($payload);

        // build stripe event
        $stripe_event_data = [
            'data' => $json_payload
        ];
        // save stripe event
        $stripe_event = StripeEvent::create($stripe_event_data);

        return new Response('OK', 200);
    }
}
