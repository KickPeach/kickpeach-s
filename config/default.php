<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'http' => [
        'host' => '0.0.0.0',
        'port' => 9080,
        'rpcEnable'=>1, //启动rpc
        'setting'=>[
            'worker_num'=>3
        ]
    ],
    'rpc' => [
        'host' => '0.0.0.0',
        'port' => 9811,
        'setting'=>[
            'worker_num'=>3
        ]
    ],
];