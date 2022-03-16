<?php

namespace Sunxyw\MinecraftProtocol\Commands;

class BungeecordCommands implements CommandsInterface
{

    /**
     * @inheritDoc
     */
    public function addWhitelist(string $player): string
    {
        throw new \Exception('not supported');
    }

    /**
     * @inheritDoc
     */
    public function removeWhitelist(string $player): string
    {
        throw new \Exception('not supported');
    }

    /**
     * @inheritDoc
     */
    public function listOnlinePlayers(): string
    {
        return 'glist showall';
    }
}