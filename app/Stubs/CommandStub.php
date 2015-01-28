<?php


namespace Avent\Stubs;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Repository\RepositoryAwareTrait;

/**
 * Class CommandStub
 * @package Avent\Stubs
 */
class CommandStub implements CommandInterface
{
    use RepositoryAwareTrait;
}

// EOF
