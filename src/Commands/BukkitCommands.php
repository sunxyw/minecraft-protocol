<?php

namespace Sunxyw\MinecraftProtocol\Commands;

/**
 * Class BukkitCommandsInterface.
 */
class BukkitCommands implements CommandsInterface
{
    /**
     * @inheritDoc
     */
    public function addWhitelist(string $player): string
    {
        return "whitelist add $player";
    }

    /**
     * @inheritDoc
     */
    public function removeWhitelist(string $player): string
    {
        return "whitelist remove $player";
    }

    /**
     * @inheritDoc
     */
    public function listOnlinePlayers(): string
    {
        return 'list';
    }
}