<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 21:42
 */

namespace Xend\Event;


class MergeConfig {
    public function run(Event $event)
    {
        $config = $event->getApplication()->config;

        $path = $config['configCachePath'];

        unset($config['config']['eventManager']['events']['dispatch::postResponse']);

        $config = var_export($config,1);

        file_put_contents($path,"<?php return ". $config.";");
    }
} 