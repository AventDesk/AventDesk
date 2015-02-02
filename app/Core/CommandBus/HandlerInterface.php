<?php


namespace Avent\Core\CommandBus;

use Avent\Core\Services\ServicesFactoryAwareInterface;

/**
 * Interface HandlerInterface
 * @package Avent\Core\CommandBus
 */
interface HandlerInterface extends ServicesFactoryAwareInterface
{
    /**
     * Handle a CommandInterface object
     * @param CommandInterface $command
     * @return mixed
     */
    public function handle(CommandInterface $command);
}

// EOF
