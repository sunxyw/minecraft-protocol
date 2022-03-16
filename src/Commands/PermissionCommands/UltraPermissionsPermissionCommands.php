<?php

namespace Sunxyw\MinecraftProtocol\Commands\PermissionCommands;

/**
 * Class UltraPermissionsPermissionCommands.
 */
class UltraPermissionsPermissionCommands implements PermissionCommandsInterface
{

    /**
     * @inheritDoc
     */
    public function addPlayerToGroup(string $player, string $group): string
    {
        return "upc addgroup $player $group";
    }

    /**
     * @inheritDoc
     */
    public function removePlayerFromGroup(string $player, string $group): string
    {
        return "upc removegroup $player $group";
    }
}