<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 21:23
 */

namespace Xend\Controller;


class AbstractController {

    private $action = "";
    private $controller = "";

    protected  $dispatchInfo;

    public function __construct($app,$dispatchInfo)
    {
        $this->app = $app;
        $this->action = strtolower($dispatchInfo['action']);
        $this->controller = strtolower($dispatchInfo['controller']);

        $this->dispatchInfo = $dispatchInfo;
    }

    public function getDb()
    {
        return $this->app->db;
    }
    
    public function getCache(){
        return $this->app->cache;
    }

    public function getView($params = array())
    {
        $view = $this->app->getNewInstant('view');
        $view->setScript($this->controller."/".$this->action.".php");

        if(!empty($params))
        {
            foreach($params as $key => $value)
            {
                $view->setVar($key,$value);
            }
        }

        return $view;
    }
} 