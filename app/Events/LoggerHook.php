<?php


namespace Avent\Events;

use Avent\Core\Event\Abstraction\BeforeAnythingAbstract;
use FastRoute\Dispatcher;
use League\Event\EventInterface;

class LoggerHook extends BeforeAnythingAbstract
{
    public function handle(EventInterface $event)
    {
        $this->logger->addDebug("{$event->getName()} triggered " . date('Y-m-d H:i:s'));
    }
}

// EOF
