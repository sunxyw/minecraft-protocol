<?php

namespace Sunxyw\MinecraftProtocol\Parser\Player;

use Sunxyw\MinecraftProtocol\Parser\ParserInterface;

/**
 * Class BasicPlayerParser.
 */
class BasicPlayerParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(string $data): mixed
    {
        preg_match_all('/\w{4,16}/', $data, $matches);
        return $matches[0];
    }

}