<?php

namespace Sunxyw\MinecraftProtocol;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Sunxyw\MinecraftProtocol\Commands\CommandsInterface;
use Sunxyw\MinecraftProtocol\Commands\PermissionCommands\PermissionCommandsInterface;

/**
 * Class ServerConfig.
 */
class ServerConfig
{
    public string $driver;

    public string $host;

    public int $port;

    public string $password;

    private array $listeners = [];

    public \Closure $playerParser;

    public CommandsInterface $commands;

    public PermissionCommandsInterface $permissionCommands;

    /**
     * Create a new ServerConfig instance from an array.
     *
     * @param array $config
     * @return static
     */
    #[Pure]
    public static function fromArray(array $config): self
    {
        $server_config = new self();
        $server_config->driver = $config['driver'];
        $server_config->host = $config['host'];
        $server_config->port = $config['port'];
        $server_config->password = $config['password'];
        $server_config->commands = $config['commands'];
        $server_config->permissionCommands = $config['permissionCommands'];
        return $server_config;
    }

    /**
     * Add a event listener.
     *
     * @param string $event
     * @param callable $listener
     * @return void
     */
    public function addListener(string $event, callable $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    /**
     * Get listeners of a event.
     *
     * @param string $event
     * @return array
     */
    #[ArrayShape(['callable'])]
    public function getListeners(string $event): array
    {
        return $this->listeners[$event] ?? [];
    }
}
