<?php

namespace Sunxyw\MinecraftProtocol\Drivers;

use JetBrains\PhpStorm\ExpectedValues;
use Sunxyw\MinecraftProtocol\MinecraftUtils;
use Sunxyw\MinecraftProtocol\ServerConfig;
use xPaw\SourceQuery\Exception\SourceQueryException;
use xPaw\SourceQuery\SourceQuery;

/**
 * Class RemoteConsoleDriver.
 * supports remote console (rcon) protocol.
 */
class RemoteConsoleDriver extends AbstractDriver
{
    private SourceQuery $connection;

    /** {@inheritDoc} */
    public function __construct(ServerConfig $config)
    {
        parent::__construct($config);
        try {
            $this->connection = new SourceQuery();
            $this->connection->Connect($config->host, $config->port);
            $this->connection->SetRconPassword($config->password);
        } catch (SourceQueryException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get the internal connection.
     *
     * @return SourceQuery
     */
    public function getConnection(): SourceQuery
    {
        return $this->connection;
    }

    /** {@inheritDoc} */
    public function dispatchCommand(string $command, array $args = [], bool $keepStyle = false): string
    {
        try {
            $result = $this->connection->Rcon($command . ' ' . implode(' ', $args));
            if (!$keepStyle) {
                MinecraftUtils::removeStyleCode($result);
            }
            $this->event('command.dispatched', $command, $args, $result);
            return $result;
        } catch (SourceQueryException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /** {@inheritDoc} */
    public function getOnlinePlayers(): array
    {
        $raw_list = $this->dispatchCommand($this->commands->listOnlinePlayers());

        if (empty($raw_list)) {
            return [];
        }

        return $this->parsePlayers($raw_list);
    }

    /** {@inheritDoc} */
    public function broadcast(string $message, string $prefix = null): void
    {
        if (!empty($prefix)) {
            $prefix = MinecraftUtils::buildComponent($prefix, 'light_purple');
        } else {
            $prefix = '';
        }
        $content = MinecraftUtils::buildComponent($message);
        $arg = MinecraftUtils::buildComponentArray(['\"\"', $prefix, $content]);
        $this->dispatchCommand("tellraw @a $arg");
    }

    /** {@inheritDoc} */
    public function assignRole(string $player, string $role): void
    {
        MinecraftUtils::validateUsername($player);
        $role = strtolower($role);
        $this->dispatchCommand($this->permissionCommands->addPlayerToGroup($player, $role));
    }

    /** {@inheritDoc} */
    public function removeRole(string $player, string $role): void
    {
        MinecraftUtils::validateUsername($player);
        $role = strtolower($role);
        $this->dispatchCommand($this->permissionCommands->removePlayerFromGroup($player, $role));
    }

    /** {@inheritDoc} */
    public function operateWhitelist(#[ExpectedValues(['add', 'remove'])] string $action, string $player): void
    {
        MinecraftUtils::validateUsername($player);
        $action = strtolower($action);
        $allowed_actions = ['add', 'remove'];
        if (!in_array($action, $allowed_actions)) {
            throw new \InvalidArgumentException("Action $action is not allowed");
        }
        $this->dispatchCommand($this->commands->{$action . 'Whitelist'}($player));
    }

    /** {@inheritDoc} */
    public function operateBan(#[ExpectedValues(['add', 'remove'])] string $action, string $player): void
    {
        MinecraftUtils::validateUsername($player);
        $action = strtolower($action);
        $allowed_actions = ['add' => 'ban', 'remove' => 'pardon'];
        if (!array_key_exists($action, $allowed_actions)) {
            throw new \InvalidArgumentException("Action $action is not allowed");
        }
        $action = $allowed_actions[$action];
        $this->dispatchCommand("$action $player");
    }
}
