<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 20:36
 */

namespace Xend\Event;


class Event {

    public $stoped = false;
    public $result = null;

    public $context;

    public function __construct($context = null)
    {
        $this->context = $context;
    }

    public function getApplication()
    {
        return \Xend\Application::getInstant();
    }

    public function getResponse()
    {
        return $this->getApplication()->response;
    }
} 