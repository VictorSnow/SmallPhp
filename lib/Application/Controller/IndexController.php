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
        $childView = $this->app->getNewInstant('view');
        $childView->setVars(array(
            'name' => 'victor'
        ));
        $childView->setScript('index.php');

        $this->app->view->addChildView('content',$childView);
        $this->app->view->setScript('layout.php');

        $content = $this->app->view->render();

        $this->app->response->setResponse($content);
        return $this->app->response;
    }
} 