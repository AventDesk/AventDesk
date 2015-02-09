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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function execute(CommandInterface $command)
    {
        $command->setRepository($this->repository);

        if (! $command instanceof UserProfileCommand) {
            throw new \DomainException(get_class($command) .
                "must be an instance of UserProfileCommand Command");
        }

        if ($violation = $this->validator->validate($command)) {
            $message = $violation->get(0)->getPropertyPath() . ":" . $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $person = $this->repository->findOneByPersonId($command->getPersonId());

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

        return ApiResponse::create()->withArray([
            "message" => "User profile updated successfully",
            "data" => $person->toArray()
        ])->send();
    }
}

// EOF
