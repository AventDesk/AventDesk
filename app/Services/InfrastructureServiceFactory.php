<?php


namespace Avent\Services;

use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Container\ContainerInterface;
use Avent\Services\Infrastructure\MailerService;

/**
 * Class InfrastructureServiceFactory
 * @package Avent\Services
 */
class InfrastructureServiceFactory implements ContainerAwareInterface
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
     * @return MailerService
     */
    public function createMailerService()
    {
        return $this->getContainer("Avent\\Services\\Infrastructure\\MailerService");
    }
}

// EOF
