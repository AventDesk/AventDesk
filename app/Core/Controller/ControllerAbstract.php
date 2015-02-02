<?php


namespace Avent\Core\Controller;

use Avent\Core\CommandBus\CommandBus;
use Avent\Core\CommandBus\CommandBusAwareInterface;
use Avent\Core\CommandBus\CommandBusAwareTrait;
use Avent\Core\Event\EventEmitterAwareInterface;
use Avent\Core\Event\EventEmitterAwareTrait;
use League\Event\EmitterInterface;

/**
 * Class ControllerAbstract
 * @package Avent\Core\Controller
 */
abstract class ControllerAbstract implements EventEmitterAwareInterface, CommandBusAwareInterface
{
    use CommandBusAwareTrait;
    use EventEmitterAwareTrait;

    /**
     * @param EmitterInterface $event
     * @param CommandBus $command_bus
     */
    public function __construct(EmitterInterface $event, CommandBus $command_bus)
    {
        $this->setEventEmitter($event);
        $this->setCommandBus($command_bus);
    }
}

// EOF
