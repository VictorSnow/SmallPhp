<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 23:38
 */

namespace Xend\Routers;


/**
 * Class Segment
 * not fully support the segment
 * @package Xend\Routers
 */
class Segment {

    private function isSegmentItem($item)
    {
        $matches = array();
        if(preg_match('/\[\:(\w+)\]/',$item,$matches))
        {
            return $matches[1];
        }
        return false;
    }


    public function match($url,$routerConfig)
    {
        $paramToMatch = explode('/',$routerConfig['url']);
        $urlMatch = explode('/',$url);

        foreach($urlMatch as $key => $part)
        {
            if($part == "")
            {
                continue;
            }elseif($part == $paramToMatch[$key])
            {
                continue;
            }elseif($match = $this->isSegmentItem($paramToMatch[$key]))
            {
                $routerConfig[$match] = $part;
            }else{
                return false;
            }
        }
        return $routerConfig;
    }
} 