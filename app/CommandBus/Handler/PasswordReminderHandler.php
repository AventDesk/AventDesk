<?php


namespace Avent\CommandBus\Handler;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;

/**
 * Class PasswordReminderHandler
 * @package Avent\CommandBus\Handler
 */
class PasswordReminderHandler implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(CommandInterface $command)
    {
        $password_remind_service = $this->getDomainServicesFactory()->createPasswordReminderService();

        return $password_remind_service->execute($command);
    }
}

// EOF
