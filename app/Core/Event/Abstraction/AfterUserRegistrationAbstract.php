<?php


namespace Avent\Core\Event\Abstraction;

use Avent\CommandBus\Command\UserRegistrationCommand;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Event\EventListenerInterface;
use Avent\Core\Event\IsListenerTrait;
use Avent\Core\Logger\LoggerAwareInterface;
use Avent\Core\Logger\LoggerAwareTrait;
use League\Event\EventInterface;
use Monolog\Logger;

/**
 * Class AfterUserRegistrationAbstract
 * @package Avent\Core\Event\Abstraction
 */
abstract class AfterUserRegistrationAbstract implements EventListenerInterface, LoggerAwareInterface
{
    use IsListenerTrait;
    use LoggerAwareTrait;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param EventInterface $event
     * @param UserRegistrationCommand $command
     * @return mixed
     */
    abstract public function handle(EventInterface $event, UserRegistrationCommand $command = null);

    /**
     * @return string
     */
    public static function getEventName()
    {
        return EventEmitter::AFTER_USER_REGISTRATION;
    }
}

// EOF
