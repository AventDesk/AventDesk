<?php


namespace Avent\Core\Event;

use Avent\Core\Event\Exception\InvalidEventNameException;
use League\Container\ContainerAwareTrait;
use League\Event\Emitter;
use League\Container\ContainerAwareInterface;

class EventEmitter extends Emitter implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const BEFORE_APP = "before.app";
    const AFTER_APP = "after.app";
    const BEFORE_DISPATCH = "before.dispatch";
    const AFTER_DISPATCH = "after.dispatch";

    public function addListener($event, $listener, $priority = self::P_NORMAL)
    {
        $class_reflection = new \ReflectionClass("Avent\\Core\\Event\\EventEmitter");
        $event_names = $class_reflection->getConstants();

        if (!in_array($event, $event_names) && !($event == "*")) {
            throw new InvalidEventNameException("Event name {$event} is not valid");
        }

        return parent::addListener($event, $listener, $priority);
    }
}

// EOF
