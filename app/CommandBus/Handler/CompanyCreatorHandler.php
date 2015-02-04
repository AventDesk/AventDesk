<?php


namespace Avent\CommandBus\Handler;

use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;

/**
 * Class CompanyCreatorHandler
 * @package Avent\CommandBus\Handler
 */
class CompanyCreatorHandler implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function handle(CommandInterface $command)
    {
        $company_creator_service = $this->getDomainServicesFactory()->createCompanyCreatorService();

        return $company_creator_service->execute($command);
    }
}

// EOF
