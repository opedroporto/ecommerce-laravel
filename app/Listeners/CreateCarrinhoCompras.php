<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Carrinho;

class CreateCarrinhoCompras
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
    public function handle(Registered $event): void
    {
        $carrinho_data = [
            'id_usuario' => $event->user->id
        ];
        Carrinho::create($carrinho_data);
    }
}
