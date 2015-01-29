<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\UserRegistrationCommand;
use Avent\Entity\Person;
use Avent\Repository\PersonRepository;
use Avent\Response\ApiResponse;
use League\Event\EmitterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegistrationService
{
    private $repository;

    private $validator;

    private $hasher;

    private $event_emitter;

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

    public function register(UserRegistrationCommand $command)
    {
        $this->event_emitter->emit("before.user.registration", $command);

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
