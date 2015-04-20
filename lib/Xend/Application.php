<?php
namespace Xend;

use Xend\Event\Event;

class Application{

    private $config;
    private $components;
    private static $instant;

    private static $defaultConfig = array(
        'components' => array(
            'dispatcher'=> 'Xend\Dispacher',
            'request' => 'Xend\Request',
            'response' => 'Xend\Response',
            'eventManager' => 'Xend\EventManager'
        ),
        'config' => array(
            'eventManager' =>array(
                'events' => array(
                    'dispatch::404' => 'Xend\Event\Page404'
                )
            )
        )
    );

    private function __construct($config)
    {
        $path = $config['configCachePath'];

        if(file_exists($path) && $config['configCacheEnable'])
        {
            $config = include $path;
        }else{
            $config = array_merge_recursive(self::$defaultConfig,$config);

            // cache config
            if($config['configCacheEnable'])
            {
                $config['config']['eventManager']['events']['dispatch::postResponse'] = 'Xend\Event\MergeConfig';
            }
        }
        $this->config = $config;
    }

    public static function getInstant()
    {
        return self::$instant;
    }

    protected  function initComponents()
    {
        $components = $this->config['components'];
        foreach($components as $key => $class)
        {
            $config = array();
            if(isset($this->config['config'][$key]))
                $config = $this->config['config'][$key];
            $this->$key = new $class($config);
        }
    }

    public static function init($config)
    {
        $app = new Application($config);
        self::$instant = $app;

        return $app;
    }

    public function run()
    {
        $dispatchInfo = $this->dispatcher->dispatch($this->request);

        if($dispatchInfo !== false)
        {
            $controllerClass = '\\'.$dispatchInfo['module'].'\\Controller\\'.$dispatchInfo['controller'].'Controller';
            $action = $dispatchInfo['action']."Action";
            $controller = new $controllerClass();

            $this->eventManager->trigger('dispatch::preAction',new Event(array(
                'controller' => $controller,
                'action' => $action
            )));
            $controller->app = $this;
            $response = $controller->$action($dispatchInfo);

            $this->eventManager->trigger('dispatch::postAction',new Event($response));
        }else{
            $event = $this->eventManager->trigger('dispatch::404',new Event());
            $response = $event->result;
        }

        $response->sendResponse();
        $this->eventManager->trigger('dispatch::postResponse',new Event());
    }

    public function __get($name)
    {
        if($name == 'config')
        {
            return $this->config;
        }
        elseif(isset($this->components[$name]))
        {
            return $this->components[$name];
        }
        elseif(isset($this->config['components'][$name]))
        {
            $class = $this->config['components'][$name];

            $config = array();
            if(isset($this->config['config'][$name]))
                $config = $this->config['config'][$name];
            $this->components[$name] = new $class($config);

            return $this->components[$name];
        }
        return null;
    }
}