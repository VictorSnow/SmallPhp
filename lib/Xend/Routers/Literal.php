<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 19:35
 */

namespace Xend\Routers;


class Literal {
    public function match($url,$routerConfig)
    {
        if($url == $routerConfig['url'])
        {
            return $routerConfig;
        }
        return false;
    }
} 