<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs\Core\Config;


class Config
{
    private static $configMap = [];
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function load()
    {
        $confFiles = glob(CONFIG_PATH . '/*.php');
        if (!empty($confFiles)) {
            foreach ($confFiles as $fileName) {
                self::$configMap = array_merge(self::$configMap,include $fileName);
            }
        }
    }

    public static function get(string $name)
    {
        if (isset(self::$configMap[$name])) {
            return self::$configMap[$name];
        }
        return false;
    }


}