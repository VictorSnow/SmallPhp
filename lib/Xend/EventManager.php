<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/20
 * Time: 20:30
 */

namespace Xend;

use Xend\Event\Event;

class EventManager {

    private $eventQueues = array();

    public function __construct($config)
    {
        $events = $config['events'];

        foreach($events as $name => $class)
        {
            $this->attach($name,$class);
        }
    }

    public function attach($name,$class,$priority = 1)
    {
        if(!isset($this->eventQueues[$name]))
        {
            $this->eventQueues[$name] = new \SplPriorityQueue();

        }
        $this->eventQueues[$name]->insert(array(
            'name' => $name,
            'callback' => $class
        ),$priority);
    }

    public function trigger($name,\Xend\Event\Event $event)
    {
        if(isset($this->eventQueues[$name]))
        {
            $eventQueue = $this->eventQueues[$name];
            $eventQueue->top();
            while($eventQueue->valid())
            {
                if(!$event->stoped)
                {
                    $eventItem = $eventQueue->current();
                    $className = $eventItem['callback'];
                    $class = new $className();
                    $event->result = $class->run($event);
                }
                else{
                    break;
                }
                $eventQueue->next();
            }
        }
        return $event;
    }
} 