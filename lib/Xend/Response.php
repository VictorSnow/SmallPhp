<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 19:41
 */

namespace Xend;


class Response {

    private static $statusMapper = array(
        '200' => 'OK',
        '404'=> 'Not Found'
    );

    private $content = "";
    private $statusCode = 200;

    public function setResponse($content,$statusCode = 200)
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
    }

    public function sendResponse()
    {
        header("HTTP/1.1 ".$this->statusCode." ".self::$statusMapper[$this->statusCode]);
        echo $this->content;
    }
} 