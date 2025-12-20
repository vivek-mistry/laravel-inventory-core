<?php

namespace VivekMistry\InventoryCore\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use VivekMistry\InventoryCore\InventoryServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;


abstract class TestCase extends Orchestra
{
     use RefreshDatabase;
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
    }
    protected function setUp(): void
    {
        parent::setUp();

        require_once __DIR__ . '/../vendor/autoload.php';
    }

    protected function getPackageProviders($app)
    {
        return [
            InventoryServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Test-only migrations (products table)
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Dummy product table
        $this->loadLaravelMigrations();
        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }
}
