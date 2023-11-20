<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Endereco;
use App\Models\FormaDePagamento;
use App\Models\Pedido;
use App\Models\Usuario;

use App\Models\Produto;
use App\Models\Colecao;
use App\Models\Item;

use DateInterval;

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class AdminPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $pedidos = Pedido::with("usuario")->with("items_pedido")->with("forma_de_pagamento")->where("nome", "LIKE", "%" . $request->search . "%")->orderByDesc('created_at')->paginate(5)->withQueryString();
        } else {
            $pedidos = Pedido::with("usuario")->with("items_pedido")->with("forma_de_pagamento")->orderByDesc('created_at')->paginate(5);
        }
        foreach($pedidos as $pedido) {
            foreach($pedido['items_pedido'] as $item) {
                // associated item
                if ($item['tipo'] == "colecao") {
                    $item['produto'] = Colecao::whereId($item['id_produto'])->first();
                } elseif ($item['tipo'] == "produto") {
                    $item['produto'] = Produto::whereId($item['id_produto'])->first();
                }
            }
            // gn: update status
            if ($pedido->gateway == "gn") {

                $options = [
                    "client_id" => env('GN_ID'),
                    "client_secret" => env('GN_SECRET'),
                    "pix_cert" =>  realpath(__DIR__ . "/certs/prod-certificado.p12"),
                    "sandbox" => false,
                    "debug" => false,
                    "timeout" => 30
                ];
    
                $params = [
                    "txid" => $pedido['session_id']
                ];
                
                try {
                    $api = Gerencianet::getInstance($options);
                    $response = $api->pixDetailCharge($params);

                    $expired = false;
                    $now_date = new \DateTime();
                    $exp_date = new \DateTime($response['calendario']['criacao']);
                    // $exp_date->add(new DateInterval($response['calendario']['expiracao'] . 'S'));
                    $exp_date->add(DateInterval::createFromDateString($response['calendario']['expiracao'] . ' seconds'));

                    // dd($response['calendario']['criacao'], $exp_date, $now_date, $exp_date <= $now_date);
                    // expired
                    if ($exp_date <= $now_date) {
                        Pedido::where("session_id", $response['txid'])->update([
                            "session_data" => json_encode($response),
                            "status" => "expired"
                        ]);
                    // complete
                    } else if ($exp_date > $now_date) {
                        Pedido::where("session_id", $response['txid'])->update([
                            "session_data" => json_encode($response),
                            "status" => "open"
                        ]);
                    // complete
                    } else if ($response['status'] == "CONCLUIDA") {
                        Pedido::where("session_id", $response['txid'])->update([
                            "session_data" => json_encode($response),
                            "status" => "complete"
                        ]);
                    }
                } catch (GerencianetException $e) {
                    print_r($e->code);
                    print_r($e->error);
                    print_r($e->errorDescription);
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
            }
        }

        $formas_de_pagamento = FormaDePagamento::all();
        $enderecos = Endereco::all();
        $usuarios = Usuario::whereNot("id", 1)->get();
        $produtos = Produto::all();
        $colecoes = Colecao::all();
        $statuses = [
            [
                "value" => "complete",
                "name" => "Finalizado"
            ],
            [
                "value" => "expired",
                "name" => "Expirado"
            ],
            [
                "value" => "open",
                "name" => "Aguardando pagamento"
            ]
            ];

        return view("admin.pedidos.pedidos", compact("pedidos", "formas_de_pagamento", "enderecos", "usuarios", "produtos", "colecoes", "statuses"));
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
            return redirect()->route("admin.pedidos.index");
        }
        // POST
        if($request->isMethod("post")){
            
            // validate data
            $validator = Validator::make($request->all(), [
                'valor' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route("admin.pedidos.index")
                            ->withErrors($validator)
                            ->withInput();
            }
            
            // store new pedido
            // $pedido_data = $validator->validated();
            $pedido_data = $request->all();
            unset($pedido_data['_token']);
            if ($pedido_data['modo'] == "entrega") {
                $pedido_data['entrega'] = true;
                $pedido_data['retirada'] = false;
            } elseif ($pedido_data['modo'] == "retirada") {
                $pedido_data['entrega'] = false;
                $pedido_data['retirada'] = true;
            }
            if (isset($pedido_data['pago']) && $pedido_data['pago'] == "on") {
                $pedido_data['pago'] = true;
            } else {
                $pedido_data['pago'] = false;
            }
            $pedido_data['id_forma_de_pagamento'] = FormaDePagamento::where("alias", $pedido_data['id_forma_de_pagamento'])->first()->id;
            unset($pedido_data['modo']);
            if (!isset($pedido_data['produtos'])) {
                $pedido_data['produtos'] = [];
            }
            $produtos = $pedido_data['produtos']; // produtos
            unset($pedido_data['produtos']);
            if (!isset($pedido_data['colecoes'])) {
                $pedido_data['colecoes'] = [];
            }
            $colecoes = $pedido_data['colecoes']; // coleções
            unset($pedido_data['colecoes']);

            //data & data_fim
            $pedido_data['data'] = date('Y-m-d H:i:s', strtotime($pedido_data['data'] . " ". $pedido_data['time']));
            $pedido_data['data_fim'] = date('Y-m-d H:i:s', strtotime($pedido_data['data2'] . " ". $pedido_data['time2']));
            unset($pedido_data['data2']);
            unset($pedido_data['time']);
            unset($pedido_data['time2']);

            $pedido = Pedido::create($pedido_data);

            // merge produtos / coleções
            $novos_produtos = array();
            $novas_colecoes = array();

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
            foreach($colecoes as $colecao) {
                $colecao['quantidade'] = (int)$colecao['quantidade'];
                // update already existing produto
                $exists = false;
                foreach($novas_colecoes as $index=>$nova_colecao) {
                    if ($nova_colecao['id'] == $colecao['id']) {
                        $novas_colecoes[$index]['quantidade'] += $colecao['quantidade'];
                        $exists = true;
                        break;
                    }
                }
                // new produto
                if (!$exists) {
                    array_push($novas_colecoes, $colecao);
                }
            }
            
            // store produtos / coleções
            foreach($novos_produtos as $produto) {
                $real_produto = Produto::whereId($produto['id'])->first();
                $produto_data = [
                    'id_pedido' => $pedido['id'],
                    'tipo' => "produto",
                    'nome' => $real_produto['nome'],
                    'valor' => $real_produto['valor'] * $produto['quantidade'],
                    'quantidade' => $produto['quantidade'],
                    'id_produto' => $produto['id']
                ];

                Item::create($produto_data);
            }
            foreach($novas_colecoes as $colecao) {
                $real_colecao = Colecao::whereId($colecao['id'])->first();
                $colecao_data = [
                    'id_pedido' => $pedido['id'],
                    'tipo' => "colecao",
                    'nome' => $real_colecao['nome'],
                    'valor' => $real_colecao['valor'] * $colecao['quantidade'],
                    'quantidade' => $colecao['quantidade'],
                    'id_produto' => $colecao['id']
                ];

                Item::create($colecao_data);
            }

            return redirect()->route("admin.pedidos.index");
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
            'valor' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route("admin.pedidos.index")
                        ->withErrors($validator)
                        ->withInput();
        }

        // update pedido
        // $pedido_data = $validator->validated();
        $pedido_data = $request->all();
        unset($pedido_data['_token']);
        if ($pedido_data['modo'] == "entrega") {
            $pedido_data['entrega'] = true;
            $pedido_data['retirada'] = false;
        } elseif ($pedido_data['modo'] == "retirada") {
            $pedido_data['entrega'] = false;
            $pedido_data['retirada'] = true;
        }
        if (isset($pedido_data['pago']) && $pedido_data['pago'] == "on") {
            $pedido_data['pago'] = true;
        } else {
            $pedido_data['pago'] = false;
        }
        $pedido_data['id_forma_de_pagamento'] = FormaDePagamento::where("alias", $pedido_data['id_forma_de_pagamento'])->first()->id;
        unset($pedido_data['modo']);
        if (!isset($pedido_data['produtos'])) {
            $pedido_data['produtos'] = [];
        }
        $produtos = $pedido_data['produtos']; // produtos
        unset($pedido_data['produtos']);
        if (!isset($pedido_data['colecoes'])) {
            $pedido_data['colecoes'] = [];
        }
        $colecoes = $pedido_data['colecoes']; // coleções
        unset($pedido_data['colecoes']);

        //data & data_fim
        $pedido_data['data'] = date('Y-m-d H:i:s', strtotime($pedido_data['data'] . " ". $pedido_data['time']));
        $pedido_data['data_fim'] = date('Y-m-d H:i:s', strtotime($pedido_data['data2'] . " ". $pedido_data['time2']));
        unset($pedido_data['data2']);
        unset($pedido_data['time']);
        unset($pedido_data['time2']);

        Pedido::whereId($pedido_data['id'])->update($pedido_data);
        $pedido = Pedido::whereId($pedido_data['id'])->first();

        // merge produtos / coleções
        $novos_produtos = array();
        $novas_colecoes = array();

        
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

        foreach($colecoes as $colecao) {
            $colecao['quantidade'] = (int)$colecao['quantidade'];
            // update already existing colecao
            $exists = false;
            foreach($novas_colecoes as $index=>$nova_colecao) {
                if ($nova_colecao['id'] == $colecao['id']) {
                    $novas_colecoes[$index]['quantidade'] += $colecao['quantidade'];
                    $exists = true;
                    break;
                }
            }
            // new colecao
            if (!$exists) {
                array_push($novas_colecoes, $colecao);
            }
        }

        // update produtos / colecões
        Item::where('id_pedido', $pedido_data['id'])->delete();

        foreach($novos_produtos as $produto) {
            $real_produto = Produto::whereId($produto['id'])->first();
            $produto_data = [
                'id_pedido' => $pedido['id'],
                'tipo' => "produto",
                'nome' => $real_produto['nome'],
                'valor' => $real_produto['valor'] * $produto['quantidade'],
                'quantidade' => $produto['quantidade'],
                'id_produto' => $produto['id']
            ];

            $item = Item::updateOrCreate(
                ['id_pedido' => $pedido['id'], 'id_produto' => $produto['id'], 'tipo' => "produto"],
                $produto_data
            );
        }

        foreach($novas_colecoes as $colecao) {
            $real_colecao = Colecao::whereId($colecao['id'])->first();
            $colecao_data = [
                'id_pedido' => $pedido['id'],
                'tipo' => "colecao",
                'nome' => $real_colecao['nome'],
                'valor' => $real_colecao['valor'] * $colecao['quantidade'],
                'quantidade' => $colecao['quantidade'],
                'id_produto' => $colecao['id']
            ];

            $item = Item::updateOrCreate(
                ['id_pedido' => $pedido['id'], 'id_produto' => $colecao['id'], 'tipo' => "colecao"],
                $colecao_data
            );
        }

        return redirect()->route("admin.pedidos.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Pedido::whereId($request->id)->delete();

        return redirect()->route("admin.pedidos.index");
    }

    public function destroymany(Request $request)
    {
        Pedido::whereIn("id", $request->ids)->delete();

        return redirect()->route("admin.pedidos.index");
    }
}
;