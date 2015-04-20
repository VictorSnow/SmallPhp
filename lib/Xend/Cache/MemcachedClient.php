<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 19:20
 */

namespace Xend\Cache;


class MemcachedClient {

    private $host;
    private $port;

    public function __construct($config)
    {
        $this->host = $config['host'];
        $this->port = $config['port'];
    }
} 