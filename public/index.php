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
                    array(
                        'type' => 'regex',
                        'url' => '^\/product\/(?P<productID>\d+)$',
                        'controller' => 'Product',
                        'action' => 'index',
                    ),
                    array(
                        'type' => 'segment',
                        'url' => '/[:controller]/id-[:id]',
                        'controller' => 'Product',
                        'action' => 'index',
                    )
                )
            ),
            'view' => array(
                'path' => APP_PATH."/lib/view/"
            )
        ),
        'configCachePath' => APP_PATH."/cache/config.php",
        'configCacheEnable' => false
    );


    $app = \Xend\Application::init($config);

    $response = $app->run();
