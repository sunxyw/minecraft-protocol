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

    private array $cache = [];

    public function __construct()
    {
        $this->servers = [];
        $this->defaultParsers = [
            'player' => BasicPlayerParser::class,
        ];
    }

    /**
     * Create a config instance from array.
     *
     * @param array $config
     * @return static
     */
    public static function fromArray(array $config): self
    {
        $instance = new self();
        if (count($config['servers'])) {
            foreach ($config['servers'] as $name => $server_config) {
                $instance->addServer($name, ServerConfig::fromArray($server_config));
            }
        }
        if (count($config['default_parsers'])) {
            foreach ($config['default_parsers'] as $name => $parser_class) {
                $instance->setDefaultParser($name, $parser_class);
            }
        }
        return $instance;
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
        $parser = $this->defaultParsers[$name];
        if (!isset($this->cache[$parser])) {
            $this->cache[$parser] = new $parser();
        }
        return $this->cache[$parser];
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

    /**
     * Add event listener to all servers.
     *
     * @param string $name
     * @param callable $listener
     * @return void
     */
    public function addListener(string $name, callable $listener): void
    {
        foreach ($this->servers as $server) {
            $server->addListener($name, $listener);
        }
    }
}