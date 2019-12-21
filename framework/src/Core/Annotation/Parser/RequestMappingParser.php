<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs\Core\Annotation\Parser;


use KickPeachs\Core\Annotation\Mapping\RequestMapping;
use KickPeachs\Core\Route\RouteRegister;

class RequestMappingParser
{
    /**
     * @param $annotaion RequestMapping
     */
    public function parse($annotaion)
    {
        $routeInfo = [
            'routePath' => $annotaion->getRoutePath(),
            'handle' => $annotaion->getHandle()
        ];

        RouteRegister::addRoute($annotaion->getMethod(),$routeInfo);
    }

}