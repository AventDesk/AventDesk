<?php


namespace Avent\Core\CommandBus;

/**
 * Class CommandBusAwareTrait
 * @package Avent\Core\CommandBus
 */
trait CommandBusAwareTrait
{
    /**
     * @var CommandBus
     */
    private $command_bus;

    /**
     * {@inheritdoc}
     */
    public function setCommandBus(CommandBus $command_bus)
    {
        $this->command_bus = $command_bus;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandBus()
    {
        return $this->command_bus;
    }
}

// EOF
