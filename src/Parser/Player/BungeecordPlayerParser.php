<?php

namespace Sunxyw\MinecraftProtocol\Parser\Player;

class BungeecordPlayerParser implements \Sunxyw\MinecraftProtocol\Parser\ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse(string $data): mixed
    {
        preg_match_all('/\[(\w+)][\s\n]+\((\d+)\):[\s\n]+(.*)/', $data, $matches);
        $players = [];
        foreach ($matches[0] as $i => $match) {
            $server = $matches[1][$i];
            $count = $matches[2][$i];
            $raw_players = $matches[3][$i];
            $players[$server] = explode(', ', $raw_players);
        }
        return $players;
    }
}
