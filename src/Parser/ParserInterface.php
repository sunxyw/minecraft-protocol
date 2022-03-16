<?php

namespace Sunxyw\MinecraftProtocol\Parser;

/**
 * Interface ParserInterface.
 */
interface ParserInterface
{
    /**
     * Parse data.
     *
     * @param string $data
     * @return mixed
     */
    public function parse(string $data): mixed;
}