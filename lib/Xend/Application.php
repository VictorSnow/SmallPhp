<?php
namespace Xend;

class Application{

    private $config;
    private static $instant;

    private static $defaultConfig = array(
        'components' => array(
            'dispatcher'=> 'Xend\Dispacher',
            'request' => 'Xend\Request'
        ),
    );

    private function __construct($config)
    {
        $config = array_merge_recursive(self::$defaultConfig,$config);
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
        // todo: handle 404
        if($dispatchInfo !== false)
        {
            $controllerClass = $dispatchInfo['module'].'\\Controller\\'.$dispatchInfo['controller'];
            $action = $dispatchInfo['action'];


            $controller = new $controllerClass();

            return $controller->$action();
        }
    }

    public function __get($name)
    {
        if($name == 'config')
            return $this->config;
        elseif(isset($this->config['components'][$name]))
        {
            $class = $this->config['components'][$name];

            $config = array();
            if(isset($this->config['config'][$name]))
                $config = $this->config['config'][$name];
            $this->$name = new $class($config);

            return $this->$name;
        }
        return null;
    }
}