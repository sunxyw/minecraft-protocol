<?php

namespace Sunxyw\MinecraftProtocol;

use JetBrains\PhpStorm\ArrayShape;
use Sunxyw\MinecraftProtocol\Parser\ParserInterface;
use Sunxyw\MinecraftProtocol\Parser\Player\BasicPlayerParser;

/**
 * Class Config.
 */
class Config
{
    #[ArrayShape(['string' => ServerConfig::class])]
    private array $servers;

    #[ArrayShape(['string' => ParserInterface::class])]
    private array $defaultParsers;

    public function __construct()
    {
        $this->servers = [];
        $this->defaultParsers = [
            'player' => BasicPlayerParser::class,
        ];
    }

    /**
     * Add server config.
     *
     * @param string $name
     * @param ServerConfig $config
     * @return void
     */
    public function addServer(string $name, ServerConfig $config): void
    {
        $this->servers[$name] = $config;
    }

    /**
     * Get the config of a server.
     *
     * @param string $name
     * @return ServerConfig
     */
    public function getServer(string $name): ServerConfig
    {
        return $this->servers[$name];
    }

    /**
     * Get default parser of a usage.
     *
     * @param string $name
     * @return ParserInterface
     */
    public function getDefaultParser(string $name): ParserInterface
    {
        return $this->defaultParsers[$name];
    }

    /**
     * Set default parser of a usage.
     *
     * @param string $name
     * @param ParserInterface $parser
     * @return void
     */
    public function setDefaultParser(string $name, ParserInterface $parser): void
    {
        $this->defaultParsers[$name] = $parser;
    }
}