<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\UserRegistrationCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Services\DomainServiceInterface;
use Avent\Entity\Person;
use Avent\Repository\PersonRepository;
use Avent\Response\ApiResponse;
use Avent\Services\Application\HasherService;
use Avent\Services\Application\ValidatorService;
use League\Event\EmitterInterface;

/**
 * Class UserRegistrationService
 * @package Avent\Services\Domain
 */
class UserRegistrationService implements DomainServiceInterface
{
    /**
     * @var PersonRepository
     */
    private $repository;

    /**
     * @var ValidatorService
     */
    private $validator;

    /**
     * @var HasherService
     */
    private $hasher;

    /**
     * @var EmitterInterface
     */
    private $event_emitter;

    /**
     * @param PersonRepository $repository
     * @param EmitterInterface $event_emitter
     * @param ValidatorService $validator
     * @param HasherService $hasher
     */
    public function __construct(
        PersonRepository $repository,
        EmitterInterface $event_emitter,
        ValidatorService $validator,
        HasherService $hasher
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->hasher = $hasher;
        $this->event_emitter = $event_emitter;
    }

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function execute(CommandInterface $command)
    {
        $command->setRepository($this->repository);

        if (! $command instanceof UserRegistrationCommand) {
            throw new \DomainException(get_class($command) .
                "must be an instance of UserRegistrationCommand Command");
        }

        if ($command->getPassword() == null) {
            $command->setPassword((string) rand(1000, 9999));
        }

        if (! $command instanceof UserRegistrationCommand) {
            throw new \DomainException(get_class($command) .
                "must be an instance of UserRegistration Command");
        }

        if ($violation = $this->validator->validate($command)) {
            $message = $violation->get(0)->getPropertyPath() . ":" . $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $person = new Person();
        $person->setEmail($command->getEmail());
        $person->setPassword($this->hasher->hash($command->getPassword()));

        $this->repository->save($person);

        $this->event_emitter->emit("after.user.registration", $command);

        return ApiResponse::create()->withArray([
            "message" => "User created successfully",
            "data" => $person->toArray()
        ])->send();
    }
}

// EOF
