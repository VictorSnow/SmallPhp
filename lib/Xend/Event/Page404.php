<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 20:56
 */

namespace Xend\Event;


class Page404
{
    public function run(Event $event)
    {
        $response = $event->getResponse();
        $response->setResponse('',404);
        $event->stoped = true;

        return $response;
    }
} 