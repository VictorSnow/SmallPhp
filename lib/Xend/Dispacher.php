<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 19:27
 */

namespace Xend;


class Dispacher {

    private $routers = null;
    private $defaultModule = null;
    private $instants = array();

    private static $routerMapper = array(
        'literal' => 'Xend\Routers\Literal',
        'regex' => 'Xend\Routers\Regex'
    );

    public function getRouter($type)
    {
        if(!isset($this->instants[$type]))
        {
            $routerClass = self::$routerMapper[$type];
            $router = new $routerClass();

            $this->instants[$type] = $router;
        }
        return $this->instants[$type];
    }


    public function __construct($config)
    {
        $this->routers = $config['routers'];
        $this->defaultModule = $config['defaultModule'];
    }

    public function dispatch(Request $request)
    {
        $url = $request->getRequestURI();

        foreach($this->routers as $routerConfig)
        {
            $type = $routerConfig['type'];
            $router= $this->getRouter($type);

            $match = $router->match($url,$routerConfig);
            if($match !== false)
            {
                if(!isset($match['module']))
                {
                    $match['module'] = $this->defaultModule;
                }
                return $match;
            }
        }
        return false;
    }
} 