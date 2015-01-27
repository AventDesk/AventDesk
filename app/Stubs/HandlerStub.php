<?php


namespace Avent\Stubs;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;

class HandlerStub implements HandlerInterface
{
    public function handle(CommandInterface $command)
    {
        return true;
    }
}

// EOF
