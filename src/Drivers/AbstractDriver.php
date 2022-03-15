<?php

namespace Sunxyw\MinecraftProtocol\Drivers;

use Illuminate\Support\Str;
use JetBrains\PhpStorm\ExpectedValues;
use Sunxyw\MinecraftProtocol\MinecraftUtils;
use Sunxyw\MinecraftProtocol\ServerConfig;

abstract class AbstractDriver implements DriverInterface
{
    protected ServerConfig $config;

    /** {@inheritDoc} */
    public function __construct(ServerConfig $config)
    {
        $this->config = $config;
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
        $event = str_replace('.', '_', $event);
        $event = Str::camel('on_' . $event);
        if (is_callable([$this->config, $event])) {
            $this->config->{$event}(...$args);
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
        if (is_callable([$this->config, 'parsePlayers'])) {
            return $this->config->parsePlayers($players);
        }
        return MinecraftUtils::parsePlayers($players);
    }
}
