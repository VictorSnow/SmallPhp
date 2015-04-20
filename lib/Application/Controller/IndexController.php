<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 21:17
 */

namespace Application\Controller;


class IndexController {
    public function indexAction()
    {
        $this->app->response->setResponse("Index page");
        return $this->app->response;
    }
} 