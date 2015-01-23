<?php


namespace Avent\Core\Event;

use League\Event\ListenerInterface;

interface EventListenerInterface extends ListenerInterface
{
    /**
     * @return string
     */
    public function getEventName();
}

// EOF
