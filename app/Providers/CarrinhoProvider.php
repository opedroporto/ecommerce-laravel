<?php

namespace App\Providers;

use Darryldecode\Cart\Cart;
use Illuminate\Support\ServiceProvider;

use App\DBStorage;

class CarrinhoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->singleton('carrinho', function($app)
        // {
        //     $storage = new DBStorage();
        //     $events = $app['events'];
        //     $instanceName = 'carrinho';
        //     $session_key = session()->getId();
        //     return new Cart(
        //         $storage,
        //         $events,
        //         $instanceName,
        //         $session_key,
        //         config('shopping_cart')
        //     );
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Event::listen('auth.login', function() {
        //     // Session::set('variableName', $value);
        // });
    }
}
