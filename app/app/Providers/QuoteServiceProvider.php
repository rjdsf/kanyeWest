<?php

namespace App\Providers;

use App\Managers\QuoteManager;
use Illuminate\Support\ServiceProvider;

class QuoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(QuoteManager::class, function ($app) {
            return new QuoteManager($app);
        }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
