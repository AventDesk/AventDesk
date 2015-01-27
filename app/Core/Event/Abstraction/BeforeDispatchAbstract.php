<?php


namespace Avent\Core\Event\Abstraction;

use Avent\Core\Event\EventEmitter;
use Avent\Core\Event\EventListenerInterface;
use Avent\Core\Event\IsListenerTrait;
use FastRoute\Dispatcher;
use League\Event\EventInterface;
use Monolog\Logger;

/**
 * Class BeforeDispatchAbstract
 * @package Avent\Core\Event\Abstraction
 */
abstract class BeforeDispatchAbstract implements EventListenerInterface
{
    use IsListenerTrait;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param EventInterface $event
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    abstract public function handle(EventInterface $event, Dispatcher $dispatcher = null);

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @return string
     */
    public static function getEventName()
    {
        return EventEmitter::BEFORE_DISPATCH;
    }
}

// EOF
