<?php

namespace Sunxyw\MinecraftProtocol\Drivers;

use JetBrains\PhpStorm\ExpectedValues;
use Sunxyw\MinecraftProtocol\ServerConfig;

/**
 * Interface DriverInterface.
 */
interface DriverInterface
{
    /**
     * Driver constructor.
     *
     * @param ServerConfig $config
     */
    public function __construct(ServerConfig $config);

    /**
     * Dispatch a command to the server.
     *
     * @param string $command
     * @param array $args
     * @return string command output
     */
    public function dispatchCommand(string $command, array $args = []): string;

    /**
     * Get the online players.
     *
     * @return array online players' usernames
     */
    public function getOnlinePlayers(): array;

    /**
     * Broadcast a message to all online players.
     *
     * @param string $message
     * @return void
     */
    public function broadcast(string $message): void;

    /**
     * Assign a player to a role.
     *
     * @param string $player
     * @param string $role
     * @return void
     */
    public function assignRole(string $player, string $role): void;

    /**
     * Remove a player from a role.
     *
     * @param string $player
     * @param string $role
     * @return void
     */
    public function removeRole(string $player, string $role): void;

    /**
     * Operate player's whitelist.
     *
     * @param string $action add|remove
     * @param string $player
     * @return void
     */
    public function operateWhitelist(#[ExpectedValues(['add', 'remove'])] string $action, string $player): void;

    /**
     * Operate player's ban.
     *
     * @param string $action add|remove
     * @param string $player
     * @return void
     */
    public function operateBan(#[ExpectedValues(['add', 'remove'])] string $action, string $player): void;
}
