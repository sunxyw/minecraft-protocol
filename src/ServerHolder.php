<?php

namespace Sunxyw\MinecraftProtocol;

use JetBrains\PhpStorm\ArrayShape;
use Sunxyw\MinecraftProtocol\Drivers\DriverInterface;

/**
 * Class ServerHolder.
 */
class ServerHolder
{
    private static ?ServerHolder $instance = null;

    private Config $config;

    #[ArrayShape(['string' => DriverInterface::class])]
    private array $servers = [];

    private function __construct()
    {
    }

    /**
     * Get the instance of the server holder.
     *
     * @return ServerHolder
     */
    public static function getInstance(): ServerHolder
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get the config.
     *
     * @return Config
     */
    public static function getConfig(): Config
    {
        return self::getInstance()->config;
    }

    /**
     * Set the config of the server holder.
     *
     * @param Config $config
     * @return void
     */
    public static function setConfig(Config $config): void
    {
        self::getInstance()->config = $config;
    }

    /**
     * Get the server by the name.
     *
     * @param string $name
     * @return DriverInterface
     */
    public static function getServer(string $name): DriverInterface
    {
        if (!array_key_exists($name, self::getInstance()->servers)) {
            $server_config = self::getConfig()->getServer($name);
            $driver = $server_config->driver;
            $server = new $driver($server_config);
            self::getInstance()->servers[$name] = $server;
        }
        return self::getInstance()->servers[$name];
    }

    /**
     * Remove a server from the holder.
     *
     * @param string $name
     * @return void
     */
    public static function resetServer(string $name): void
    {
        if (array_key_exists($name, self::getInstance()->servers)) {
            unset(self::getInstance()->servers[$name]);
        }
    }
}

