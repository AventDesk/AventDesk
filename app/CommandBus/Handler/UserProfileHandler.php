<?php


namespace Avent\CommandBus\Handler;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;

/**
 * Class UserProfileHandler
 * @package Avent\CommandBus\Handler
 */
class UserProfileHandler implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function handle(CommandInterface $command)
    {
        $user_profile_service = $this->getDomainServicesFactory()->createUserProfileService();

        return $user_profile_service->execute($command);
    }
}

// EOF
