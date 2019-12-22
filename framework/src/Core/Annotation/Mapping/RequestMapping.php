<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace KickPeachs\Core\Annotation\Mapping;

class RequestMapping
{
    private $routePath = '';

    private $method;

    private $handle;


    public function __construct($classDocComment,$methodDocComment,$reflect,$method)
    {
        preg_match('/@Controller\((.*)\)/i', $classDocComment, $prefix);
        $prefix=str_replace("\"","",explode("=",$prefix[1])[1]);
        preg_match('/@RequestMapping\((.*)\)/i', $methodDocComment, $suffix);
        $suffix=str_replace("\"","",explode("=",$suffix[1])[1]);
        $this->routePath = $prefix.'/'.$suffix;
        //todo 注解取得方法以及获得路由参数
        $this->method = "GET";
        $this->handle = $reflect->getName()."@".$method->getName();
    }

    /**
     * @return string
     */
    public function getRoutePath(): string
    {
        return $this->routePath;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }
}