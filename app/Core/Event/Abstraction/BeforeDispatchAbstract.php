<?php


namespace Avent\Core\Event\Abstraction;

use Avent\Core\Event\EventEmitter;
use Avent\Core\Event\EventListenerInterface;
use Avent\Core\Event\IsListenerTrait;
use FastRoute\Dispatcher;
use League\Event\EventInterface;

abstract class BeforeDispatchAbstract implements EventListenerInterface
{
    use IsListenerTrait;

    abstract public function handle(EventInterface $event, Dispatcher $dispatcher = null);

    /**
     * @return string
     */
    public function getEventName()
    {
        return EventEmitter::BEFORE_DISPATCH;
    }
}

// EOF
