<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\UserAuthenticationCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Services\DomainServiceInterface;
use Avent\Entity\ApiKey;
use Avent\Entity\Person;
use Avent\Repository\ApiKeyRepository;
use Avent\Repository\PersonRepository;
use Avent\Response\ApiResponse;
use Avent\Services\Application\ValidatorService;
use League\Route\Http\Exception;

/**
 * Class UserAuthenticationService
 * @package Avent\Services\Domain
 */
class UserAuthenticationService implements DomainServiceInterface
{
    /**
     * @var PersonRepository
     */
    private $person_repository;

    /**
     * @var ApiKeyRepository
     */
    private $apikey_repository;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    /**
     * @var ValidatorService
     */
    private $validator;

    /**
     * @param PersonRepository $person_repository
     * @param ApiKeyRepository $apikey_repository
     * @param EventEmitter $event_emitter
     * @param ValidatorService $validator
     */
    public function __construct(
        PersonRepository $person_repository,
        ApiKeyRepository $apikey_repository,
        EventEmitter $event_emitter,
        ValidatorService $validator
    ) {
        $this->person_repository = $person_repository;
        $this->apikey_repository = $apikey_repository;
        $this->event_emitter = $event_emitter;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(CommandInterface $command)
    {
        if (! $command instanceof UserAuthenticationCommand) {
            throw new \DomainException(get_class($command) . "must be an instance of UserRegistration Command");
        }

        $this->event_emitter->emit("before.user.auth");

        if ($violation = $this->validator->validate($command)) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $person = $this->verifyPassword($command->getPassword(), $command->getPassword());

        $api_key = $this->apikey_repository->findOneBy(["person_id" => $person->getPersonId()]);

        if (is_null($api_key)) {
            $api_key = $this->generateApiKey($person);
        }

        $this->event_emitter->emit("after.user.auth");

        return ApiResponse::create()->withArray(
            [
                "message" => "Authentication success",
                "data" => $api_key->toArray()
            ]
        )->send();
    }

    /**
     * @param Person $person
     * @return ApiKey
     */
    private function generateApiKey(Person $person)
    {
        $api_key = new ApiKey();
        $api_key->setLevel(1);
        $api_key->setPerson($person);

        $this->apikey_repository->save($api_key);

        return $api_key;
    }

    /**
     * @param $email
     * @param $password
     * @return Person
     */
    private function verifyPassword($email, $password)
    {
        $person = $this->person_repository->findOneBy(["email" => $email]);

        if (is_null($person)) {
            throw new \DomainException("Email not found in database");
        }

        if (! password_verify($password, $person->getPassword())) {
            throw new \DomainException("Invalid email or password");
        }

        return $person;
    }
}

// EOF
