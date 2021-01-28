<?php

namespace Zahav\ZahavLaravel;

use Illuminate\Support\ServiceProvider;
use Zahav\ZahavLaravel\Trader;
use Zahav\ZahavLaravel\Commands\WorkCommand;

class ZahavServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();

        $this->app->bind('zahav', function () {
            return new Trader();
        });
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

    /**
     * Register the package commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                WorkCommand::class
            ]);
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/coinspot.php' => config_path('coinspot.php'),
            ]);

            $this->publishes([
                __DIR__.'/../config/zahav.php' => config_path('zahav.php'),
            ]);
        }
    }
}