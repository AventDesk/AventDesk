<?php


namespace Avent\Services;

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Container\ContainerInterface;
use Avent\Services\Domain\UserRegistrationService;
use Avent\Services\Domain\UserProfileService;
use Avent\Services\Domain\CompanyCreatorService;
use Avent\Services\Domain\UserAuthenticationService;

/**
 * Class DomainServiceFactory
 * @package Avent\Services
 */
class DomainServiceFactory implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * @return UserRegistrationService
     */
    public function createUserRegistrationService()
    {
        return $this->container->get("Avent\\Services\\Domain\\UserRegistrationService");
    }

    /**
     * @return UserProfileService
     */
    public function createUserProfileService()
    {
        return $this->container->get("Avent\\Services\\Domain\\UserProfileService");
    }

    /**
     * @return CompanyCreatorService
     */
    public function createCompanyCreatorService()
    {
        return $this->container->get("Avent\\Services\\Domain\\CompanyCreatorService");
    }

    /**
     * @return UserAuthenticationService
     */
    public function createUserAuthenticationService()
    {
        return $this->container->get("Avent\\Services\\Domain\\UserAuthenticationService");
    }
}

// EOF
