<?php

namespace Sunxyw\MinecraftProtocol;

use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ServerConfig.
 */
class ServerConfig
{
    public string $driver;

    public string $host;

    public int $port;

    public string $password;

    public array $allowedRoles;

    public string $assignRoleCommand;

    public string $removeRoleCommand;

    private array $listeners = [];

    public \Closure $playerParser;

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
