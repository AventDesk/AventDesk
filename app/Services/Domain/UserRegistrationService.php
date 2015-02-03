<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\UserRegistrationCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Services\DomainServiceInterface;
use Avent\Entity\Person;
use Avent\Repository\PersonRepository;
use Avent\Response\ApiResponse;
use League\Event\EmitterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @var ValidatorInterface
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
     * @param ValidatorInterface $validator
     * @param HasherService $hasher
     */
    public function __construct(
        PersonRepository $repository,
        EmitterInterface $event_emitter,
        ValidatorInterface $validator,
        HasherService $hasher
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->hasher = $hasher;
        $this->event_emitter = $event_emitter;
    }

    /**
     * @param CommandInterface $command
     * @return Response
     * @throws \Exception
     */
    public function execute(CommandInterface $command)
    {
        if (! $command instanceof UserRegistrationCommand) {
            throw new \Exception(get_class($command) . "must be an instance of UserRegistration Command");
        }

        $this->event_emitter->emit("before.user.registration", $command);

        $command->setRepository($this->repository);

        $response = ApiResponse::create();

        if ($command->getPassword() == null) {
                $command->setPassword((string) rand(1000, 9999));
        }

        try {
            $violation = $this->validator->validate($command);

            if (count($violation) > 0) {
                return $response->withValidationError(
                    [
                        "message" => "Validation error"
                    ],
                    $violation
                )->send(Response::HTTP_NOT_ACCEPTABLE);
            }

            $person = new Person();
            $person->setEmail($command->getEmail());
            $person->setPassword($this->hasher->hash($command->getPassword()));

            $this->repository->save($person);

            $this->event_emitter->emit("after.user.registration", $command);

            return $response->withArray([
                "message" => "User created successfully",
                "data" => $person->toArray()
            ])->send();
        } catch (\Exception $e) {
            $this->event_emitter->emit("on.error", $e);
            return $response->withArray([
                "message" => "Oops something went wrong"
            ])->send(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

// EOF
