<?php

namespace Sunxyw\MinecraftProtocol;

use Illuminate\Support\ServiceProvider;

class MinecraftProtocolServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'sunxyw');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'sunxyw');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/minecraft-protocol.php', 'minecraft-protocol');

        // Register the service the package provides.
        $this->app->singleton('minecraft-protocol', function ($app) {
            return new MinecraftProtocol;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['minecraft-protocol'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/minecraft-protocol.php' => config_path('minecraft-protocol.php'),
        ], 'minecraft-protocol.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/sunxyw'),
        ], 'minecraft-protocol.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/sunxyw'),
        ], 'minecraft-protocol.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/sunxyw'),
        ], 'minecraft-protocol.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
