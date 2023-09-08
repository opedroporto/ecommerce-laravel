<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\CarrinhoCompras;

class TransferCarrinhoCompras
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $items = CarrinhoCompras::getItems(asGuest: true);
        foreach ($items as $item) {
            unset($item['id']);
            CarrinhoCompras::setItem($item);
        }
    }
}
