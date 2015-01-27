<?php


namespace Avent\Core\CommandBus;

/**
 * Interface InflectorInterface
 * @package Avent\Core\CommandBus
 */
interface InflectorInterface
{
    /**
     * Find handler for CommandInterface
     * @param CommandInterface $command
     * @return string
     */
    public function inflect(CommandInterface $command);
}

// EOF
