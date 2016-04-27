<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 23:18
 */

namespace Xend\Routers;


class Regex 
{
    public function match($url,$routerConfig)
    {
        $pattern = "/".$routerConfig['url']."/";
        $matches = array();
        if(preg_match($pattern,$url,$matches))
        {
            foreach($matches as $key => $value)
            {
                if(!is_numeric($key))
                    $routerConfig[$key] = $value;
            }
            return $routerConfig;
        }
        return false;
    }
} 