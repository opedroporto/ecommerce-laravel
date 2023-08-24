<?php

namespace App;

use App\Models\Carrinho;
use App\Models\Item;

class CarrinhoCompras {

    public function __construct() {
        //
    }

    public static function setItem(array $item_dados) {
        
        // user
        if (auth()->user()) {
            $id_carrinho = Carrinho::where("id_usuario", auth()->user()->id)->first()->id;
            
            // update already existing item
            if ($existing_item = Item::where("id_carrinho", $id_carrinho)->where("id_produto", $item_dados['id_produto'])->first()) {
                $id_produto = $item_dados['id_produto'];
                $new_quantidade = $existing_item['quantidade'] + $item_dados['quantidade'];
                self::updateItem($id_produto, [
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
                    if ($item['id_produto'] == $item_dados['id_produto']) {
                        $existing_item = $item;
                    }
                }
                // update already existing item
                if ($existing_item) {
                    $id_produto = $item_dados['id_produto'];
                    $new_quantidade = $existing_item['quantidade'] + $item_dados['quantidade'];
                    self::updateItem($item_dados['id_produto'], [
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
            $items = Item::with("produto")->where("id_carrinho", $id_carrinho)->get()->toArray(); // items

        // guest
        } else {
            if (!session()->has("carrinho")) {
                $items = [];
            } else {
                $items = session()->get("carrinho");
            }
        }   

        return $items;
    }

    public static function updateItem(int $id_produto, array $new_dados) {
        // user
        if (auth()->user()) {
            $new_item = Item::where("id_produto", $id_produto)->update($new_dados);
        
        // guest
        } else {
            $items = session()->get("carrinho");
            $index = 0;
            foreach ($items as $item) {
                if ($item['id_produto'] == $id_produto) {
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

    public static function clear() {
        
    }
}

