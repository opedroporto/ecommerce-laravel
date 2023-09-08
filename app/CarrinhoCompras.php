<?php

namespace App;

use App\Models\Carrinho;
use App\Models\Item;
use App\Models\Produto;
use App\Models\Colecao;

class CarrinhoCompras {

    public function __construct() {
        //
    }

    public static function setItem(array $item_dados) {
        
        // user
        if (auth()->user()) {
            $id_carrinho = Carrinho::where("id_usuario", auth()->user()->id)->first()->id;
            
            // update already existing item
            if ($existing_item = Item::where("id_carrinho", $id_carrinho)->where("id_produto", $item_dados['id_produto'])->where("tipo", $item_dados['tipo'])->first()) {
                $id = $existing_item['id'];
                $new_quantidade = $existing_item['quantidade'] + $item_dados['quantidade'];

                // with
                if ($existing_item['tipo'] == "colecao") {
                    $existing_item['produto'] = Colecao::find($existing_item['id_produto'])->first();
                } else {
                    $existing_item['produto'] = Produto::find($existing_item['id_produto'])->first();
                }

                self::updateItem($id, [
                    'quantidade' => $new_quantidade,
                    'valor' => $new_quantidade * $existing_item['produto']['valor']
                ]);
            // new item
            } else {
                unset($item_dados['produto']);
                $item_dados['id_carrinho'] = $id_carrinho;
                Item::create($item_dados);
            }

        // guest
        } else {
            if (!session()->has("carrinho")) {
                session()->put("carrinho", [$item_dados]);
            } else {
                $existing_item = false;
                $items = session()->get("carrinho");
                foreach ($items as $item) {
                    if ($item['id_produto'] == $item_dados['id_produto'] && $item['tipo'] == $item_dados['tipo']) {
                        $existing_item = $item;
                    }
                }
                // update already existing item
                if ($existing_item) {
                    $id_produto = $item_dados['id_produto'];
                    $new_quantidade = $existing_item['quantidade'] + $item_dados['quantidade'];

                    // with
                    if ($existing_item['tipo'] == "colecao") {
                        $existing_item['produto'] = Colecao::find($existing_item['id_produto'])->first();
                    } else {
                        $existing_item['produto'] = Produto::find($existing_item['id_produto'])->first();
                    }

                    self::updateItem($existing_item['id'], [
                        'quantidade' => $new_quantidade,
                        'valor' => $new_quantidade * $existing_item['produto']['valor']
                    ]);
                // new item
                } else {
                    $items = session()->get("carrinho");
                    array_push($items, $item_dados);
                    session()->put("carrinho", $items);
                } 
            } 
        }

        return true;
    }

    public static function getItems(bool $asGuest=false) {
        // user
        if (!$asGuest && auth()->user()) {
            // get items
            $id_carrinho = Carrinho::where("id_usuario", auth()->user()->id)->first()->id;
            // $items = Item::with("produto")->where("id_carrinho", $id_carrinho)->get()->toArray(); // items
            $items = Item::where("id_carrinho", $id_carrinho)->get()->toArray(); // items
            // with
            $new_items = [];
            foreach($items as $item) {
                if ($item['tipo'] == "colecao") {
                    $item['produto'] = Colecao::find($item['id_produto'])->first();
                } else {
                    $item['produto'] = Produto::find($item['id_produto'])->first();
                }
                array_push($new_items, $item);
            }
            return $new_items;

        // guest
        } else {
            if (!session()->has("carrinho")) {
                $items = [];
            } else {
                $items = session()->get("carrinho");
            }
            return $items;
        }   

    }

    public static function getItem($id, bool $asGuest=false) {
        // user
        if (!$asGuest && auth()->user()) {
            // get items
            $id_carrinho = Carrinho::where("id_usuario", auth()->user()->id)->first()->id;
            // $item = Item::with("produto")->where("id_carrinho", $id_carrinho)->whereId($id)->get()->first(); // item
            $item = Item::where("id_carrinho", $id_carrinho)->whereId($id)->get()->first(); // item
            // with
            if ($item['tipo'] == "colecao") {
                $item['produto'] = Colecao::find($item['id_produto'])->first();
            } else {
                $item['produto'] = Produto::find($item['id_produto'])->first();
            }
            // $item = Item::with("produto")->whereId($id)->get()->first(); // item
        // guest
        } else {
            if (!session()->has("carrinho")) {
                $item = []; // item
            } else {
                $items = session()->get("carrinho");
                foreach($items as $each_item) {
                    if ($each_item['id'] == $id) {
                        $item = $each_item; // item
                    }
                }
            }
        }   

        return $item;
    }

    public static function updateItem($id, array $new_dados) {
        // user
        if (auth()->user()) {
            Item::whereId($id)->update($new_dados);
            $new_item = Item::whereId($id)->get()->first();
        
        // guest
        } else {
            $items = session()->get("carrinho");
            $index = 0;
            foreach ($items as $item) {
                if ($item['id'] == $id) {
                    foreach ($new_dados as $key => $value) {
                        $item[$key] = $value;
                    }
                    $new_item = $item;
                    $items[$index] = $new_item;
                }
                $index++;
            }
            session()->put("carrinho", $items);
        }
        
        return $new_item;
    }

    public static function getTotal() {
        $items = self::getItems();

        if (!empty($items)) {
            // items total price
            $itemsPreco = array_column($items, "valor");
            $total = array_sum($itemsPreco); // total
        } else {
            $total = 0;
        }

        return $total;
    }

    public static function getItemsQuantity() {
        $items = self::getItems();
        $itemsQuantity = count($items); // quantidade items
        
        return $itemsQuantity;
    }

    public static function deleteItem($id) {
        // user
        if (auth()->user()) {
            // get items
            $id_carrinho = Carrinho::where("id_usuario", auth()->user()->id)->first()->id;
            Item::where("id_carrinho", $id_carrinho)->whereId($id)->delete(); // del
        // guest
        } else {
            if (session()->has("carrinho")) {
                $items = session()->get("carrinho");

                $new_carrinho = [];
                foreach($items as $each_item) {
                    if ($each_item['id'] != $id) {
                        array_push($new_carrinho, $each_item);
                    }
                }
                session()->put("carrinho", $new_carrinho); // del
            }
        }
    }

    public static function clear() {
        // user
        if (auth()->user()) {
            $items = self::getItems();
            foreach ($items as $item) {
                Item::find($item->id)->delete();
            }
        // guest
        } else {
            session()->put("carrinho", "");
        }
    }

    public static function getId() {
        if (auth()->user()) {
            $id_carrinho = Carrinho::where("id_usuario", auth()->user()->id)->first()->id;
            return $id_carrinho;
        }
        // return false;
    }

    public static function getAdditional() {
        return 50.00;
    }
}

