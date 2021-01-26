<?php

namespace Zahav\ZahavLaravel;

use Illuminate\Support\ServiceProvider;

class ZahavServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/coinspot.php' => config_path('coinspot.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
    }

    /**
     * Setup the configuration for Coinspot.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/coinspot.php', 'coinspot'
        );
    }
}