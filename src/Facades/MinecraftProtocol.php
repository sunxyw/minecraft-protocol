<?php

namespace Sunxyw\MinecraftProtocol\Facades;

use Illuminate\Support\Facades\Facade;

class MinecraftProtocol extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'minecraft-protocol';
    }
}
