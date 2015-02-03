<?php


namespace Avent\Core\Services;

use Avent\Services\DomainServiceFactory;
use Avent\Services\InfrastructureServiceFactory;

/**
 * Class ServicesFactoryAwareTrait
 * @package Avent\Core\Services
 */
trait ServicesFactoryAwareTrait
{
    /**
     * @var DomainServiceFactory
     */
    private $domain_services;

    /**
     * @var InfrastructureServiceFactory
     */
    private $infrastructure_services;

    /**
     * @param DomainServiceFactory $domain_services
     * @param InfrastructureServiceFactory $infra_services
     */
    public function __construct(DomainServiceFactory $domain_services, InfrastructureServiceFactory $infra_services)
    {
        $this->setDomainServicesFactory($domain_services);
        $this->setInfrastructureServicesFactory($infra_services);
    }

    /**
     * {@inheritdoc}
     */
    public function setDomainServicesFactory(DomainServiceFactory $domain_services)
    {
        $this->domain_services = $domain_services;
    }

    /**
     * {@inheritdoc}
     */
    public function setInfrastructureServicesFactory(InfrastructureServiceFactory $infrastructure_services)
    {
        $this->infrastructure_services = $infrastructure_services;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomainServicesFactory()
    {
        return $this->domain_services;
    }

    /**
     * {@inheritdoc}
     */
    public function getInfrastructureServicesFactory()
    {
        return $this->infrastructure_services;
    }
}

// EOF
