<?php

namespace Sunxyw\MinecraftProtocol;

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

    public \Closure $onCommandDispatched;

    public \Closure $parsePlayers;
}