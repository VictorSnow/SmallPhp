<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/21
 * Time: 0:11
 */

namespace Xend\Event;

use \Xend\View;

class View2Response {
    public function run(Event $event)
    {
        $response = $event->context;

        if($response instanceof View)
        {

            $view = $response;
            if($view->enableLayout)
            {
                $rootView = $event->getApplication()->view;
                $rootView->addChildView('content',$view);
                $rootView->setScript($view->getLayoutScript());

                $view = $rootView;
            }
            $event->getResponse()->setResponse($view->render());
        }elseif(is_string($response))
        {
            $event->getResponse()->setResponse($response);
        }
    }
} 