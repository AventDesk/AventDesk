<?php


namespace Avent\Core\Event\Abstraction;

use Avent\Core\Event\EventEmitter;
use Avent\Core\Event\EventListenerInterface;
use Avent\Core\Event\IsListenerTrait;
use Avent\Core\Logger\LoggerAwareInterface;
use Avent\Core\Logger\LoggerAwareTrait;
use League\Event\EventInterface;
use Monolog\Logger;

/**
 * Class SecurityEventAbstract
 * @package Avent\Core\Event\Abstraction
 */
abstract class SecurityEventAbstract implements EventListenerInterface, LoggerAwareInterface
{
    use IsListenerTrait;
    use LoggerAwareTrait;

    /**
     * @param EventInterface $event
     * @param array $request
     * @param array $acl
     */
    abstract public function handle(EventInterface $event, $request = [], $acl = []);

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
        return EventEmitter::SECURITY_EVENT;
    }
}

// EOF
