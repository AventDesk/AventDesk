<?php


namespace Avent\CommandBus\Handler;


use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\CommandBus\HandlerInterface;
use Avent\Services\Domain\HasherService;
use Avent\Services\Domain\UserRegistrationService;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Container\ContainerInterface;

class UserRegistrationHandler implements HandlerInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function handle(CommandInterface $command)
    {
        $repository = $this->container->get("EntityManager")->getRepository("Avent\\Repository\\PersonRepository");
        $validator = $this->container->get("Validator");
        $event_emitter = $this->container->get("EventEmitter");
        $command->setRepository($repository);
        $hash_service = new HasherService();

        $registration_service = new UserRegistrationService($repository, $event_emitter, $validator, $hash_service);

        return $registration_service->register($command);
    }
}

// EOF
