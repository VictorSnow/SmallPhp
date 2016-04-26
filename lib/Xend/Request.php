<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 19:41
 */

namespace Xend;


class Request {

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;

        $this->router = null;
    }


    public function getRequestURI()
    {
        $url = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        return $url;
    }
} 