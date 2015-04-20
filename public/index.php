<?php
    chdir(dirname(__DIR__));
	define("APP_PATH", getcwd());
    include APP_PATH."/vendor/autoload.php";

    $config = array(
        'components' => array(
            'cache'=> 'Xend\Cache\MemcachedClient'
        ),
        'config' => array(
            'cache' => array(
                'host' => 'localhost',
                'port' => 11211
            ),
            'dispatcher' => array(
                'defaultModule' => 'Application',
                'routers' => array(
                    array(
                        'type' => 'literal',
                        'url' => '/index/index',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                )
            )
        ),
    );


    $app = \Xend\Application::init($config);

    $app->run();
	
