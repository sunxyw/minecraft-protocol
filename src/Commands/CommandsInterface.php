<?php

namespace Sunxyw\MinecraftProtocol\Commands;

/**
 * Interface CommandsInterface.
 * all the public methods should return a string that represents the command
 */
interface CommandsInterface
{
    /**
     * Add player to the whitelist.
     *
     * @param string $player
     * @return mixed
     */
    public function addWhitelist(string $player): string;

    /**
     * Remove player from the whitelist.
     *
     * @param string $player
     * @return mixed
     */
    public function removeWhitelist(string $player): string;

    /**
     * List online players.
     *
     * @return string
     */
    public function listOnlinePlayers(): string;
}