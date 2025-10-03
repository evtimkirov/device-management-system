<?php

namespace App\Providers;

use App\Services\AlertManager;
use App\Services\TemperatureAlertStrategy;
use Illuminate\Support\ServiceProvider;

class AlertServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AlertManager::class, function ($app) {
            return new AlertManager([
                new TemperatureAlertStrategy(),
                // More alerts here...
            ]);
        });
    }
}
