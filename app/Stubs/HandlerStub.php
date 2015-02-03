<?php


namespace Avent\Stubs;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;

/**
 * Class HandlerStub
 * @package Avent\Stubs
 */
class HandlerStub implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    /**
     * @param CommandInterface $command
     * @return bool
     */
    public function handle(CommandInterface $command)
    {
        return true;
    }
}

// EOF
