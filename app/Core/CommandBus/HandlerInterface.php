<?php


namespace Avent\Core\CommandBus;

/**
 * Interface HandlerInterface
 * @package Avent\Core\CommandBus
 */
interface HandlerInterface
{
    /**
     * Handle a CommandInterface object
     * @param CommandInterface $command
     * @return mixed
     */
    public function handle(CommandInterface $command);
}

// EOF
