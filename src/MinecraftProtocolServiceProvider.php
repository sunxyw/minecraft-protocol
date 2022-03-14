<?php

namespace Sunxyw\MinecraftProtocol;

use Illuminate\Support\ServiceProvider;
use Sunxyw\MinecraftProtocol\Drivers\DriverInterface;

class MinecraftProtocolServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
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
        $this->mergeConfigFrom(__DIR__ . '/../config/minecraft-protocol.php', 'minecraft-protocol');

        // Register the service the package provides.
        $this->app->singleton('minecraft-protocol', function (): DriverInterface {
            /** @var DriverInterface $driver */
            $driver = config('minecraft-protocol.driver');
            return new $driver(
                config('minecraft-protocol.host'),
                config('minecraft-protocol.port'),
                config('minecraft-protocol.password')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
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
            __DIR__ . '/../config/minecraft-protocol.php' => config_path('minecraft-protocol.php'),
        ], 'minecraft-protocol.config');
    }
}
