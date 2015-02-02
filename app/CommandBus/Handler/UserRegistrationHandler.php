<?php


namespace Avent\CommandBus\Handler;


use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Core\Services\ServicesFactoryAwareTrait;
use Avent\Services\DomainServiceFactory;
use Avent\Services\InfrastructureServiceFactory;

class UserRegistrationHandler implements HandlerInterface
{
    use ServicesFactoryAwareTrait;

    public function __construct(DomainServiceFactory $domain_services, InfrastructureServiceFactory $infra_services)
    {
        $this->setDomainServicesFactory($domain_services);
        $this->setInfrastructureServicesFactory($infra_services);
    }

    public function handle(CommandInterface $command)
    {
        $registration_service = $this->getDomainServicesFactory()->createUserRegistrationService();
        return $registration_service->register($command);
    }
}

// EOF
