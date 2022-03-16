<?php

namespace Sunxyw\MinecraftProtocol\Commands\PermissionCommands;

/**
 * Interface PermissionCommandsInterface.
 */
interface PermissionCommandsInterface
{
    /**
     * Add player to group.
     *
     * @param string $player
     * @param string $group
     * @return string
     */
    public function addPlayerToGroup(string $player, string $group): string;

    /**
     * Remove player from group.
     *
     * @param string $player
     * @param string $group
     * @return string
     */
    public function removePlayerFromGroup(string $player, string $group): string;
}