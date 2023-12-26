<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(config('app.force_https')) {
            URL::forceScheme('https');
        }

        view()->composer('*', function ($view)
        {
            $view->with('global_currency_symbol', $this->getGlobalCurrencySymbol());
        });
    }

    public function getGlobalCurrencySymbol()
    {
        return "₱";
    }
}
