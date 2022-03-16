<?php

namespace Sunxyw\MinecraftProtocol\Commands\PermissionCommands;

/**
 * Class GroupManagerPermissionCommands.
 */
class GroupManagerPermissionCommands implements PermissionCommandsInterface
{

    /**
     * @inheritDoc
     */
    public function addPlayerToGroup(string $player, string $group): string
    {
        return "manuadd $player $group";
    }

    /**
     * @inheritDoc
     */
    public function removePlayerFromGroup(string $player, string $group): string
    {
        return "manudel $player $group";
    }
}