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

    public function __construct($app, $dispatchInfo)
    {
        /**
         * @var \Xend\Application
         */
        $this->app = $app;
        $this->action = strtolower($dispatchInfo['action']);
        $this->controller = strtolower($dispatchInfo['controller']);

        $this->dispatchInfo = $dispatchInfo;
    }

    public function getSession()
    {
        return $this->app->session;
    }

    public function getDb()
    {
        return $this->app->db;
    }
    
    public function getCache(){
        return $this->app->cache;
    }

    public function beforeAction()
    {
        return true;
    }

    public function redirect($url)
    {
        header('location: '.$url, true, 302);
        exit;
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