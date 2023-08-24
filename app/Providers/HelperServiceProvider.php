<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
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
        $allHelperFiles = glob(app_path("Helpers") . "/*.php");

        foreach($allHelperFiles as $key => $helperFile) {
            require_once $helperFile;
        }
    }
}
