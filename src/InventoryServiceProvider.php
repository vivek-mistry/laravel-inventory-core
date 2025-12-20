<?php

namespace VivekMistry\InventoryCore;

use Illuminate\Support\ServiceProvider;

class InventoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/inventory.php',
            'inventory'
        );

        $this->app->singleton('inventory', function () {
            return new Services\InventoryService();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/inventory.php' => config_path('inventory.php'),
        ], 'inventory-config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
