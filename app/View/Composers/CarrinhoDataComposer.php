<?php

namespace App\View\Composers;

use App\CarrinhoCompras;
use illuminate\View\View;

class CarrinhoDataComposer {
    public function __construct() {
        //
    }
    public function compose(View $view) {
        
        $quantidadeItemsCarrinho = CarrinhoCompras::getItemsQuantity();

        $view->with(compact("quantidadeItemsCarrinho"));
    }
}