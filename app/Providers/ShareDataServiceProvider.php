<?php

namespace App\Providers;

use App\View\Composers\CarrinhoDataComposer;
use Illuminate\Support\ServiceProvider;

class ShareDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer("*", CarrinhoDataComposer::class);
    }
}
