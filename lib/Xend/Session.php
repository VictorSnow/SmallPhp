<?php

namespace Xend;

class Session
{
    public function __construct($config = array())
    {
        session_start();
    }

    public function __get($name)
    {
        return isset($_SESSION[$name])? $_SESSION[$name]: null;
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
}