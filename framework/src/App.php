<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs;

use Swoole;

class App
{
    public function run()
    {
        $http = new Swoole\Http\Server("0.0.0.0", 9080);
        $http->on('request', function ($request, $response) {
            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        });
        $http->start();
    }

}