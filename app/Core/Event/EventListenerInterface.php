<?php


namespace Avent\Core\Event;

use League\Event\ListenerInterface;
use Monolog\Logger;

/**
 * Interface EventListenerInterface
 * @package Avent\Core\Event
 */
interface EventListenerInterface extends ListenerInterface
{

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger);

    /**
     * @return string
     */
    public static function getEventName();
}

// EOF
