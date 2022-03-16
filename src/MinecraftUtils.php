<?php

namespace Sunxyw\MinecraftProtocol;

use InvalidArgumentException;

/**
 * Class MinecraftUtils.
 */
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
     * Build a Minecraft-compatible component string.
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
    public static function buildComponent($text, string $color = 'gray', bool $bold = false, bool $italic = false, bool $underlined = false, bool $strikethrough = false, bool $obfuscate = false): string
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

    /**
     * Build a Minecraft-compatible components string.
     *
     * @param array $components components, array of string returned by buildComponent(), or valid component json string
     * @return string
     */
    public static function buildComponentArray(array $components): string
    {
        return '[' . implode(',', $components) . ']';
    }
}
