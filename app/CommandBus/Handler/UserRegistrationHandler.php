<?php


namespace Avent\CommandBus\Handler;


use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;

/**
 * Class UserRegistrationHandler
 * @package Avent\CommandBus\Handler
 */
class UserRegistrationHandler implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(CommandInterface $command)
    {
        $registration_service = $this->getDomainServicesFactory()->createUserRegistrationService();
        return $registration_service->execute($command);
    }
}

// EOF
