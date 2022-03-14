<?php

namespace Sunxyw\MinecraftProtocol\Drivers;

use JetBrains\PhpStorm\ExpectedValues;
use Sunxyw\MinecraftProtocol\MinecraftUtils;
use xPaw\SourceQuery\Exception\SourceQueryException;
use xPaw\SourceQuery\SourceQuery;

/**
 * Class RemoteConsoleDriver.
 * supports remote console (rcon) protocol.
 */
class RemoteConsoleDriver implements DriverInterface
{
    private SourceQuery $connection;

    /** {@inheritDoc} */
    public function __construct($host, $port, $password)
    {
        try {
            $this->connection = new SourceQuery();
            $this->connection->Connect($host, $port);
            $this->connection->SetRconPassword($password);
        } catch (SourceQueryException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /** {@inheritDoc} */
    public function dispatchCommand(string $command, array $args = []): string
    {
        try {
            return $this->connection->Rcon($command . ' ' . implode(' ', $args));
        } catch (SourceQueryException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /** {@inheritDoc} */
    public function getOnlinePlayers(): array
    {
        $raw_list = $this->dispatchCommand('list');

        if (empty($raw_list)) {
            return [];
        }

        MinecraftUtils::removeStyleCode($raw_list);
        return MinecraftUtils::parsePlayers($raw_list);
    }

    /** {@inheritDoc} */
    public function broadcast(string $message, string $prefix = null): void
    {
        if (!empty($prefix)) {
            $prefix = MinecraftUtils::buildComponent('Prefix here', 'light_purple');
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
        $allowed_roles = ['primary', 'introduction'];
        if (!in_array($role, $allowed_roles)) {
            throw new \InvalidArgumentException("Role $role is not allowed");
        }
        // TODO: support others permission plugin
        $this->dispatchCommand("manuadd $player $role");
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
        $this->dispatchCommand("whitelist $action $player");
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
