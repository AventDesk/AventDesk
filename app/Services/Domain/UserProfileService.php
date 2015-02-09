<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\UserProfileCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Services\DomainServiceInterface;
use Avent\Repository\PersonRepository;
use Avent\Response\ApiResponse;
use Avent\Services\Application\ValidatorService;
use Avent\ValueObject\Address;
use Avent\ValueObject\Social;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserProfileService
 * @package Avent\Services\Domain
 */
class UserProfileService implements DomainServiceInterface
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
     * @var ValidatorService
     */
    private $validator;

    /**
     * @param PersonRepository $repository
     * @param EventEmitter $event_emitter
     * @param ValidatorService $validator
     */
    public function __construct(
        PersonRepository $repository,
        EventEmitter $event_emitter,
        ValidatorService $validator
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
            throw new \Exception(get_class($command) .
                "must be an instance of UserProfileCommand Command");
        }

        $this->event_emitter->emit("before.user.profile.editor", $command);

        $command->setRepository($this->repository);

        $response = ApiResponse::create();

        try {
            if ($violation = $this->validator->validate($command)) {
                throw new \InvalidArgumentException("Validation failed");
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

            $this->event_emitter->emit("after.user.profile.editor", $command);
            return $response->withArray([
                "message" => "User profile updated successfully",
                "data" => $person->toArray()
            ])->send();

        } catch (\InvalidArgumentException $e) {
            return $response->withValidationError([
                $e->getMessage()
            ], $violation)->send(Response::HTTP_NOT_ACCEPTABLE);
        } catch (\Exception $e) {
            $this->event_emitter->emit("on.error", $e);
            return $response->withArray([
                "message" => "Oops something went wrong"
            ])->send(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

// EOF
