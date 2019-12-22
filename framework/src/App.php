<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs;

use KickPeachs\Core\Bean\BeanFactory;
use KickPeachs\Core\Http\HttpServer;
use KickPeachs\Core\Rpc\Rpc;

class App
{
    public function run($argv)
    {

        //加载注解文件
        $this->init();
        switch ($argv[1]) {
            case 'http:start':
                (new HttpServer())->run();
                break;
            case "rpc:start":
                (new Rpc())->run();
                break;
            default:
                echo "未知参数，感谢您的使用！" . PHP_EOL;
                break;
        }
    }

    private function init()
    {
        define('ROOT_PATH', dirname(dirname(__DIR__)));
        define('APP_PATH', ROOT_PATH . '/app');
        define('CONFIG_PATH', ROOT_PATH . '/Config');

        $bean = require APP_PATH . '/bean.php';
        foreach ($bean as $name => $instance) {
            BeanFactory::set($name, $instance);
        }
    }

}