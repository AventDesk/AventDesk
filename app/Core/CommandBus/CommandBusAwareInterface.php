<?php


namespace Avent\Core\CommandBus;

/**
 * Interface CommandBusAwareInterface
 * @package Avent\Core\CommandBus
 */
interface CommandBusAwareInterface
{
    /**
     * @param CommandBus $command_bus
     * @return void
     */
    public function setCommandBus(CommandBus $command_bus);

    /**
     * @return CommandBus
     */
    public function getCommandBus();
}

// EOF
