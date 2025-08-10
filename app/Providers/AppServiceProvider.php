<?php

namespace App\Providers;

use App\Services\FlipTransaction;
use App\Services\TransactionReport;
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
        $this->app->singleton("transactionReport", function ($app) {
            return new TransactionReport;
        });

        $this->app->singleton("flipTransaction", function ($app) {
            return new FlipTransaction;
        });

        if ($this->app->environment("production")) {
            URL::forceScheme("https");
        }
    }
}
