<?php


namespace Avent\Core\Services;

use Avent\Services\DomainServiceFactory;
use Avent\Services\InfrastructureServiceFactory;

/**
 * Interface ServicesFactoryAwareInterface
 * @package Avent\Core\Services
 */
interface ServicesFactoryAwareInterface
{
    /**
     * @param DomainServiceFactory $domain_service
     * @return mixed
     */
    public function setDomainServicesFactory(DomainServiceFactory $domain_service);

    /**
     * @param InfrastructureServiceFactory $infrastructure_factory
     * @return mixed
     */
    public function setInfrastructureServicesFactory(InfrastructureServiceFactory $infrastructure_factory);

    /**
     * @return DomainServiceFactory
     */
    public function getDomainServicesFactory();

    /**
     * @return InfrastructureServiceFactory
     */
    public function getInfrastructureServicesFactory();
}

// EOF
