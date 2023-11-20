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

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class PaymentController extends Controller
{
    // public function webhookResponse(Request $request) {
    //     response()->json(['success' => 'success'], 200);
    // }

    public function seeCharges(Request $request) {
        $options = [
            "client_id" => env('GN_ID'),
            "client_secret" => env('GN_SECRET'),
            "pix_cert" =>  realpath(__DIR__ . "/certs/prod-certificado.p12"),
            "sandbox" => false,
            "debug" => false,
            "timeout" => 30
        ];

        $options["headers"] = [
            "x-skip-mtls-checking" => "true",
        ];
        
        $params = [
            "inicio" => "2021-01-01T00:00:00Z",
            "fim" => "2024-12-31T23:59:59Z"
        ];
        
        try {
            $api = Gerencianet::getInstance($options);
            $response = $api->pixListCharges($params);
        
            print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    
    public function seeWebhook(Request $request) {
        $options = [
            "client_id" => env('GN_ID'),
            "client_secret" => env('GN_SECRET'),
            "pix_cert" =>  realpath(__DIR__ . "/certs/prod-certificado.p12"),
            "sandbox" => false,
            "debug" => false,
            "timeout" => 30
        ];

        $options["headers"] = [
            "x-skip-mtls-checking" => "true",
        ];
        
        $params = [
            "inicio" => "2021-01-01T00:00:00Z",
            "fim" => "2024-12-31T23:59:59Z"
        ];
        
        try {
            $api = Gerencianet::getInstance($options);
            $response = $api->pixListWebhook($params);
        
            print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function setWebhook(Request $request) {
        $options = [
            "client_id" => env('GN_ID'),
            "client_secret" => env('GN_SECRET'),
            "pix_cert" =>  realpath(__DIR__ . "/certs/prod-certificado.p12"),
            "sandbox" => false,
            "debug" => false,
            "timeout" => 30
        ];

        $options["headers"] = [
            "x-skip-mtls-checking" => "true",
        ];
        
        $params = [
            "chave" => "339d0eaf-5a38-4487-8db7-594c23602b55"
        ];
        
        $body = [
            "webhookUrl" => "https://tcc.eastus.cloudapp.azure.com/webhook"
        ];
        
        try {
            $api = Gerencianet::getInstance($options);
            $response = $api->pixConfigWebhook($params, $body);
        
            print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function checkout(Request $request) {
        $pedido = Pedido::with("forma_de_pagamento")->whereId($request->id)->get()->first();

        $items = Item::where("id_pedido", $request->id)->get()->all();

        if ($pedido->forma_de_pagamento->alias == "c") {
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
                        // "unit_amount" => 25
                    ],
                    "quantity" => $item->quantidade
                ];
            }
            // dd($line_items);
            
            if ($pedido['entrega']) {
                // + montagem
                $line_items[] = [
                    "price_data" => [
                        "currency" => "brl",
                        "product_data" => [
                            "name" => "Adicional de montagem"
                        ],
                        "unit_amount" => CarrinhoCompras::getAdditional() * 100
                        // "unit_amount" => 25
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
                        // "unit_amount" => 25
                    ],
                    "quantity" => 1
                ];
            }

            $time = new DateTime();
            $time->modify('+30 minutes');
            $timestamp = $time->getTimestamp();
            // create checkout session
            $session = $stripe->checkout->sessions->create([
                "line_items" => $line_items,
                "mode" => "payment",
                "success_url" => route("site.getpedidos"),
                "cancel_url" => route("site.index"),
                "expires_at" => $timestamp,
                // "client_reference_id" => auth()->user()->id
            ]);
            // set order payment uri
            Pedido::whereId($pedido->id)->update([
                "gateway" => "stripe",
                "session_data" => json_encode($session),
                "session_id" => $session->id,
                "uri_pagamento" => $session->url
            ]);

            return redirect()->away($session->url);
        } else if ($pedido->forma_de_pagamento->alias == "pix") {
            $options = [
                "client_id" => env('GN_ID'),
                "client_secret" => env('GN_SECRET'),
                "pix_cert" =>  realpath(__DIR__ . "/certs/prod-certificado.p12"),
                "sandbox" => false,
                "debug" => false,
                "timeout" => 30
            ];

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
                        // "unit_amount" => 25
                    ],
                    "quantity" => $item->quantidade
                ];
            }
            
            if ($pedido['entrega']) {
                // + montagem
                $line_items[] = [
                    "price_data" => [
                        "currency" => "brl",
                        "product_data" => [
                            "name" => "Adicional de montagem"
                        ],
                        "unit_amount" => CarrinhoCompras::getAdditional() * 100
                        // "unit_amount" => 25
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
                        // "unit_amount" => 25
                    ],
                    "quantity" => 1
                ];
            }
            
            $total = 0;
            foreach ($line_items as $item) {
                $total += $item['price_data']['unit_amount'] / 100;
            }

            $infoAdicionais = [];
            foreach ($line_items as $line_item) {
                $infoAdicionais[] = [
                    "nome" => $line_item['price_data']['product_data']['name'],
                    "valor" => $line_item['quantity'] . " x R\$" . number_format($line_item['price_data']['unit_amount'] / 100, 2, ",", ".")
                ];
            }
            
    
            $body = [
                "calendario" => [
                    "expiracao" => 1800
                ],
                // "devedor" => [
                //     "cpf" => preg_replace('/[^0-9]/', '', auth()->user()->cpf),
                //     "nome" => auth()->user()->nome
                // ],
                "valor" => [
                    "original" => number_format($total, 2, ".", ",")
                ],
                "chave" => "339d0eaf-5a38-4487-8db7-594c23602b55", // Chave pix da conta Gerencianet do recebedor
                "solicitacaoPagador" => "Obrigado por comprar conosco!",
                "infoAdicionais" => $infoAdicionais
            ];
    
            try {
                $api = Gerencianet::getInstance($options);
                $pix = $api->pixCreateImmediateCharge([], $body);
    
                if ($pix['txid']) {
                    $params = [
                        'id' => $pix['loc']['id']
                    ];

                    
                    // Gera QRCode
                    $qrcode = $api->pixGenerateQRCode($params);

                    // set order payment uri
                    Pedido::whereId($pedido->id)->update([
                        "gateway" => "gn",
                        "session_data" => json_encode($pix),
                        "session_id" => $pix['txid'],
                        "uri_pagamento" => $qrcode['linkVisualizacao']
                    ]);
    
                    // echo 'Detalhes da cobrança:';
                    // echo '<pre>' . json_encode($pix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
    
                    // echo 'QR Code:';
                    // echo '<pre>' . json_encode($qrcode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
    
                    // echo 'Imagem:<br />';
                    // echo '<img src="' . $qrcode['imagemQrcode'] . '" />';

                    return redirect()->away($qrcode['linkVisualizacao']);
                } else {
                    dd("erro");
                }
            } catch (GerencianetException $e) {
                dd($e);
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
    
                throw new Error($e->error);
            } catch (Exception $e) {
                throw new Error($e->getMessage());
            }
        }


    }

    public function success() {
        return view("site.index");
    }

    public function webhookStripe(Request $request) {

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
            /**/
        // build stripe event
        $stripe_event_data = [
            'data' => $json_payload
        ];
        // save stripe event
        $stripe_event = StripeEvent::create($stripe_event_data);

        // handle event
        $stripe = new \Stripe\StripeClient(config("stripe.pk"));

        switch($payload['type']) {
            // session paid
            case "checkout.session.completed":
                $session_id = $payload['data']['object']['id'];
                // retrieve session
                $session_data = $stripe->checkout->sessions->retrieve(
                    $session_id,
                    []
                );
                // update Pedido
                Pedido::where("session_id", $session_id)->update([
                    "pago" => true,
                    "session_data" => json_encode($session_data),
                    // "session_id" => $session_id,
                    // "uri_pagamento" => $session_data->url
                    "status" => "complete"
                ]);
                break;
            // session expired
            case "checkout.session.expired":
                $session_id = $payload['data']['object']['id'];
                // retrieve session
                $session_data = $stripe->checkout->sessions->retrieve(
                    $session_id,
                    []
                );
                // update Pedido
                Pedido::where("session_id", $session_id)->update([
                    "session_data" => json_encode($session_data),
                    // "session_id" => $session_id,
                    "uri_pagamento" => $session_data->url,
                    "status" => "expired"
                ]);
                break;
        }

        return new Response('OK', 200);
    }

    public function webhookGn(Request $request) {

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
            /**/

        $options = [
            "client_id" => env('GN_ID'),
            "client_secret" => env('GN_SECRET'),
            "pix_cert" =>  realpath(__DIR__ . "/certs/prod-certificado.p12"),
            "sandbox" => false,
            "debug" => false,
            "timeout" => 30
        ];

        $params = [
            "txid" => $payload['pix'][0]['txid']
        ];
        
        try {
            $api = Gerencianet::getInstance($options);
            $response = $api->pixDetailCharge($params);
        
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/custom.log'),
            ])->info($response);

            if ($reponse['status'] == "CONCLUIDA") {
                Pedido::where("session_id", $response['txid'])->update([
                    "session_data" => json_encode($response),
                    // "uri_pagamento" => $session_data->url,
                    "status" => "complete"
                ]);
            }

            // Log::build([
            //     'driver' => 'single',
            //     'path' => storage_path('logs/custom.log'),
            // ])->info(json_decode($response, true));
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
            
        return new Response('OK', 200);
    }
}
