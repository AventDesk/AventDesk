<?php


namespace Avent\Stubs;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;

class HandlerStub implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    public function handle(CommandInterface $command)
    {
        return true;
    }
}

// EOF
