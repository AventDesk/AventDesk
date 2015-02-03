<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\UserProfileCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Event\EventEmitter;
use Avent\Repository\PersonRepository;
use Avent\Response\ApiResponse;
use Avent\ValueObject\Address;
use Avent\ValueObject\Social;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserProfileService
 * @package Avent\Services\Domain
 */
class UserProfileService
{
    /**
     * @var PersonRepository
     */
    private $repository;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param PersonRepository $repository
     * @param EventEmitter $event_emitter
     * @param ValidatorInterface $validator
     */
    public function __construct(
        PersonRepository $repository,
        EventEmitter $event_emitter,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->event_emitter = $event_emitter;
        $this->validator = $validator;
    }

    /**
     * @param CommandInterface $command
     * @return Response
     * @throws \Exception
     */
    public function execute(CommandInterface $command)
    {
        if (! $command instanceof UserProfileCommand) {
            throw new \Exception(get_class($command) . "must be an instance of UserRegistration Command");
        }

        $this->event_emitter->emit("before.user.profile.editor", $command);

        $command->setRepository($this->repository);

        $response = ApiResponse::create();

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


            $person = $this->repository->findOneByPersonId($command->getPersonId());

            if ($person == null) {
                throw new \Exception("Person not found");
            }

            $address = new Address();
            $address->setCity($command->getCity());
            $address->setCountry($command->getCountry());
            $address->setState($command->getState());
            $address->setStreet($command->getStreet());
            $address->setZipCode($command->getZipCode());

            $social = new Social();
            $social->setFacebook($command->getFacebook());
            $social->setTwitter($command->getTwitter());
            $social->setWebsite($command->getWebsite());

            $person->setAddress($address);
            $person->setSocial($social);

            $this->repository->save($person);

            $this->event_emitter->emit("before.user.profile.editor", $command);
            return $response->withArray([
                "message" => "User profile updated successfully",
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
