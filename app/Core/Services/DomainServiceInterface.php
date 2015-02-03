<?php


namespace Avent\Core\Services;

use Avent\Core\CommandBus\CommandInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface DomainServiceInterface
 * @package Avent\Core\Services
 */
interface DomainServiceInterface
{
    /**
     * @param CommandInterface $command
     * @return Response
     */
    public function execute(CommandInterface $command);
}

// EOF
