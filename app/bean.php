<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */
return [
    'Config'=>function(){
        return  \KickPeachs\Core\Config\Config::getInstance();
    },
    'Route'=>function(){
        return  \KickPeachs\Core\Route\Route::getInstance();
    },
    'Reload'=>function(){
        return \KickPeachs\Core\Reload\Reload::getInstance();
    }
];