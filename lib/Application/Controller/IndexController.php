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
        return "hello world<a href='http://localhost/vlite/public/index.php?r=/index/index'>haha</a>";
        $childView = $this->app->getNewInstant('view');
        $childView->setVars(array(
            'name' => 'victor'
        ));
        $childView->setScript('index.php');
        return $childView;
    }
} 