<?php

namespace Sunxyw\MinecraftProtocol\Parser\Player;

class BungeecordPlayerParser implements \Sunxyw\MinecraftProtocol\Parser\ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse(string $data): mixed
    {
        preg_match('/\[(\w+)[\S\s]*\((\d+).* [\r\n]+([\w,\s]+)/', $data, $matches);
        [, $server, $count, $raw_players] = $matches;
        $raw_players = trim($raw_players);
        $raw_players = preg_replace('/\d player.*/', '', $raw_players);
        return explode(', ', $raw_players);
    }
}