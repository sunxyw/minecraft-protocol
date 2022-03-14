<?php

namespace Sunxyw\MinecraftProtocol\Drivers;

use Sunxyw\MinecraftProtocol\MinecraftUtils;
use xPaw\SourceQuery\Exception\SourceQueryException;
use xPaw\SourceQuery\SourceQuery;

class RemoteConsoleDriver implements DriverInterface
{
    private SourceQuery $connection;

    public function __construct($host, $port, $password)
    {
        try {
            $this->connection = new SourceQuery();
            $this->connection->Connect($host, $port);
            $this->connection->SetRconPassword($$password);
        } catch (SourceQueryException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function dispatchCommand(string $command, array $args = []): string
    {
        try {
            return $this->connection->Rcon($command . ' ' . implode(' ', $args));
        } catch (SourceQueryException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getOnlinePlayers(): array
    {
//        $raw_list = $this->dispatchCommand('list');
        $raw_list = <<<EOT
当前有 1 个玩家在线,最大在线人数为 2,021 个玩家.
Introduction: [夕阳]sunxyw
Primary: [初建]Acent
EOT;

        if (empty($raw_list)) {
            return [];
        }

        MinecraftUtils::removeStyleCode($raw_list);
        return MinecraftUtils::parsePlayers($raw_list);
    }

    public function broadcast(string $message): void
    {
        $prefix = MinecraftUtils::encodeComponent('Prefix here', 'light_purple');
        $content = MinecraftUtils::encodeComponent('Content here');
        $this->dispatchCommand("tellraw @a [\"\",{$prefix},{$content}]");
    }

    public function assignRole(string $player, string $role): void
    {
        MinecraftUtils::validateUsername($player);
        $role = strtolower($role);
        $allowed_roles = ['primary', 'introduction'];
        if (!in_array($role, $allowed_roles)) {
            throw new \InvalidArgumentException("Role {$role} is not allowed");
        }
        // TODO: support others permission plugin
        $this->dispatchCommand("manuadd {$player} {$role}");
    }

    public function operateWhitelist(string $action, string $player): void
    {
        MinecraftUtils::validateUsername($player);
        $action = strtolower($action);
        $allowed_actions = ['add', 'remove'];
        if (!in_array($action, $allowed_actions)) {
            throw new \InvalidArgumentException("Action {$action} is not allowed");
        }
        $this->dispatchCommand("whitelist {$action} {$player}");
    }

    public function operateBan(string $action, string $player): void
    {
        MinecraftUtils::validateUsername($player);
        $action = strtolower($action);
        $allowed_actions = ['add' => 'ban', 'remove' => 'pardon'];
        if (!array_key_exists($action, $allowed_actions)) {
            throw new \InvalidArgumentException("Action {$action} is not allowed");
        }
        $action = $allowed_actions[$action];
        $this->dispatchCommand("{$action} {$player}");
    }
}
