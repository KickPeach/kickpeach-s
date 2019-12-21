<?php
/**
 * This file is part of the kickpeach/kickpeach-s.
 *
 * (c) shisiying <shisiying@xhzyxed.cn>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace App\Admin\Controller;

/**
 * Class TestController
 * @Controller(prefix="/admin")
 */
class IndexController
{
    /**
     * @RequestMapping(route="index")
     */
    public function index()
    {
        echo "xxxx";
        return "Admin";
    }

}