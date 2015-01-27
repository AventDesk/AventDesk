<?php


namespace Avent\Core\Event\Abstraction;

use Avent\Core\Event\EventListenerInterface;
use Avent\Core\Event\IsListenerTrait;
use Avent\Core\Logger\LoggerAwareInterface;
use Avent\Core\Logger\LoggerAwareTrait;
use League\Event\EventInterface;
use Monolog\Logger;

/**
 * Class BeforeAnythingAbstract
 * @package Avent\Core\Event\Abstraction
 */
abstract class BeforeAnythingAbstract implements EventListenerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    use IsListenerTrait;

    /**
     * @param EventInterface $event
     * @return void
     */
    abstract public function handle(EventInterface $event);

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
        return "*";
    }
}

// EOF
