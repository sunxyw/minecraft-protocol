<?php

namespace Sunxyw\MinecraftProtocol;

use InvalidArgumentException;

class MinecraftUtils
{
    /**
     * Validate a Minecraft username.
     *
     * @param string $username
     * @return void
     * @throws InvalidArgumentException if the username is invalid
     */
    public static function validateUsername(string $username): void
    {
        if (!preg_match('/^\w{4,16}$/', $username)) {
            throw new InvalidArgumentException('Invalid username');
        }
    }

    /**
     * Remove style codes from a string.
     *
     * @param string $string
     * @return void
     */
    public static function removeStyleCode(string &$string): void
    {
        $string = preg_replace('/(?:§|&amp;)([0-9a-fklmnor])/iu', '', $string);
    }

    /**
     * Parse players' usernames from a string.
     *
     * @param string $string
     * @return array
     */
    public static function parsePlayers(string $string): array
    {
        preg_match_all('/\[\S*](\w{4,16})/', $string, $matches);
        return $matches[1];
    }

    /**
     * Encode a string to a Minecraft-compatible component string.
     *
     * @param $text
     * @param string $color
     * @param bool $bold
     * @param bool $italic
     * @param bool $underlined
     * @param bool $strikethrough
     * @param bool $obfuscate
     * @return string
     */
    public static function encodeComponent($text, string $color = 'gray', bool $bold = false, bool $italic = false, bool $underlined = false, bool $strikethrough = false, bool $obfuscate = false): string
    {
        $component = '{';
        $component .= '"text":"' . $text . '",';
        $color !== 'gray' && $component .= '"color":"' . $color . '",';
        $bold && $component .= '"bold":true,';
        $italic && $component .= '"italic":true,';
        $underlined && $component .= '"underlined":true,';
        $strikethrough && $component .= '"strikethrough":true,';
        $obfuscate && $component .= '"obfuscated":true,';
        $component = rtrim($component, ',');
        $component .= '}';
        return $component;
    }
}
