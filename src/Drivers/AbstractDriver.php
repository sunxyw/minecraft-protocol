<?php

namespace Sunxyw\MinecraftProtocol\Drivers;

use JetBrains\PhpStorm\ExpectedValues;
use Sunxyw\MinecraftProtocol\Commands\CommandsInterface;
use Sunxyw\MinecraftProtocol\Commands\PermissionCommands\PermissionCommandsInterface;
use Sunxyw\MinecraftProtocol\MinecraftUtils;
use Sunxyw\MinecraftProtocol\ServerConfig;

/**
 * Class AbstractDriver.
 */
abstract class AbstractDriver implements DriverInterface
{
    protected ServerConfig $config;

    protected CommandsInterface $commands;

    protected PermissionCommandsInterface $permissionCommands;

    /** {@inheritDoc} */
    public function __construct(ServerConfig $config)
    {
        $this->config = $config;
        $this->commands = $config->commands;
        $this->permissionCommands = $config->permissionCommands;
    }

    /** {@inheritDoc} */
    abstract public function dispatchCommand(string $command, array $args = []): string;

    /** {@inheritDoc} */
    abstract public function getOnlinePlayers(): array;

    /** {@inheritDoc} */
    abstract public function broadcast(string $message): void;

    /** {@inheritDoc} */
    abstract public function assignRole(string $player, string $role): void;

    /** {@inheritDoc} */
    abstract public function removeRole(string $player, string $role): void;

    /** {@inheritDoc} */
    abstract public function operateWhitelist(#[ExpectedValues(['add', 'remove'])] string $action, string $player): void;

    /** {@inheritDoc} */
    abstract public function operateBan(#[ExpectedValues(['add', 'remove'])] string $action, string $player): void;

    /**
     * Emit an event.
     *
     * @param string $event
     * @param ...$args
     * @return void
     */
    protected function event(string $event, ...$args): void
    {
        foreach ($this->config->getListeners($event) as $listener) {
            $listener(...$args);
        }
    }

    /**
     * Parse players' usernames from a string.
     * if custom players parser is set, it will use it.
     * otherwise, the built-in parser will be used.
     *
     * @param string $players
     * @return array
     */
    protected function parsePlayers(string $players): array
    {
        if (isset($this->config->playerParser)) {
            $parser = $this->config->playerParser;
            return $parser($players);
        }
        return MinecraftUtils::parsePlayers($players);
    }
}
