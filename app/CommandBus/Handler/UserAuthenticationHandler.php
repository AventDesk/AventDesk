<?php


namespace Avent\CommandBus\Handler;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;

/**
 * Class UserAuthenticationHandler
 * @package Avent\CommandBus\Handler
 */
class UserAuthenticationHandler implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(CommandInterface $command)
    {
        $user_auth_service = $this->getDomainServicesFactory()->createUserAuthenticationService();

        return $user_auth_service->execute($command);
    }
}

// EOF
