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

    private CommandsInterface $commands;

    private PermissionCommandsInterface $permissionCommands;

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

    /**
     * @param $commands
     * @return void
     */
    public function setCommands($commands): void
    {
        $this->commands = new $commands();
    }

    /**
     * @return CommandsInterface
     */
    public function getCommands(): CommandsInterface
    {
        return $this->commands;
    }

    /**
     * @param $permissionCommands
     * @return void
     */
    public function setPermissionCommands($permissionCommands): void
    {
        $this->permissionCommands = new $permissionCommands();
    }

    /**
     * @return PermissionCommandsInterface
     */
    public function getPermissionCommands(): PermissionCommandsInterface
    {
        return $this->permissionCommands;
    }
}
