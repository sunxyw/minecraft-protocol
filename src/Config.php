<?php

namespace Sunxyw\MinecraftProtocol;

use JetBrains\PhpStorm\ArrayShape;

/**
 * Class Config.
 */
class Config
{
    #[ArrayShape(['string' => ServerConfig::class])]
    private array $servers;

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
}