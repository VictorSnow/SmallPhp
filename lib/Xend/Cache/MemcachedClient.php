<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 19:20
 */

namespace Xend\Cache;

use \Memcached;

/**
 * wrapper for memcached
 * Class MemcachedClient
 * @package Xend\Cache
 */
class MemcachedClient {

    private $_host;
    private $_port;

    private $_instant = null;

    public function __construct($config)
    {
        $this->_host = $config['host'];
        $this->_port = $config['port'];

        $this->_instant = new Memcached();
        $this->_instant->addServer($this->_host,$this->_port);
    }

    public function __call($name,$arguments)
    {
        return call_user_func_array(array($this->_instant,$name),$arguments);
    }
} 