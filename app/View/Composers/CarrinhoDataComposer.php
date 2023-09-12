<?php

namespace App\View\Composers;

use App\CarrinhoCompras;
use illuminate\View\View;

class CarrinhoDataComposer {
    public function __construct() {
        //
    }
    public function compose(View $view) {
        // guest or not admin (normal user)
        if (auth()->guest() || auth()->user()->role == 0) {
            $quantidadeItemsCarrinho = CarrinhoCompras::getItemsQuantity();
    
            $view->with(compact("quantidadeItemsCarrinho"));
        } else if (auth()->user()->role == 1) {
            $quantidadeItemsCarrinho = 0;
    
            $view->with(compact("quantidadeItemsCarrinho"));
        }
    }
}