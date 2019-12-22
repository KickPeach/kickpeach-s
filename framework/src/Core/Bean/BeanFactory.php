<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs\Core\Bean;


class BeanFactory
{
    private static $containers = [];

    public static function get(string $name)
    {
        if (isset(self::$containers[$name])) {
            return (self::$containers[$name])();
        }
    }

    public static function set(string $name,callable $func)
    {
        self::$containers[$name] = $func;
    }
}