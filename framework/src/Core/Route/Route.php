<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs\Core\Route;


class Route
{
    private static $route = [];
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance =  new self();
        }

        return self::$instance;
    }

    public static function addRoute(string $method, array $routeInfo)
    {
        self::$route[$method] = $routeInfo;
    }

    public static function dispatch($method,$pathInfo)
    {
        switch ($method) {
            case 'GET':
                foreach (self::$route[$method] as $v) {
                    if ($pathInfo == $v['routePath']) {
                        $handle = explode("@", $v['handle']);
                        $class = $handle[0];
                        $method = $handle[1];
                        return (new $class)->$method();
                    }
                }
                break;

        }

    }
}