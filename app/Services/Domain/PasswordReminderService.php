<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\PasswordReminderCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Services\DomainServiceInterface;
use Avent\Entity\PasswordReminder;
use Avent\Repository\PasswordReminderRepository;
use Avent\Repository\PersonRepository;
use Avent\Response\ApiResponse;
use Avent\Services\Application\ValidatorService;
use Avent\ValueObject\Timestamp;

/**
 * Class PasswordReminderService
 * @package Avent\Services\Domain
 */
class PasswordReminderService implements DomainServiceInterface
{
    /**
     * @var PasswordReminderRepository
     */
    private $password_remind_repository;

    /**
     * @var PersonRepository
     */
    private $person_repository;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    /**
     * @var ValidatorService
     */
    private $validator;

    /**
     * @param PasswordReminderRepository $password_remind_repository
     * @param PersonRepository $person_repository
     * @param EventEmitter $event_emitter
     * @param ValidatorService $validator
     */
    public function __construct(
        PasswordReminderRepository $password_remind_repository,
        PersonRepository $person_repository,
        EventEmitter $event_emitter,
        ValidatorService $validator
    ) {
        $this->password_remind_repository = $password_remind_repository;
        $this->person_repository = $person_repository;
        $this->event_emitter = $event_emitter;
        $this->validator = $validator;
    }

    /**
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function execute(CommandInterface $command)
    {
        $command->setRepository($this->person_repository);

        if (! $command instanceof PasswordReminderCommand) {
            throw new \DomainException(get_class($command) .
                "must be an instance of PasswordReminderCommand Command");
        }

        if ($violation = $this->validator->validate($command)) {
            $message = $violation->get(0)->getPropertyPath() . ":" . $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $person = $this->person_repository->findOneBy(["email" => $command->getEmail()]);

        $password_reminder = new PasswordReminder();
        $password_reminder->setPerson($person);
        $password_reminder->setIsActive(true);
        $password_reminder->setTimestamp(new Timestamp());

        $this->password_remind_repository->save($password_reminder);

        return ApiResponse::create()->withArray(
            [
                "message" => "Password reminder code successfully created",
                "data" => $password_reminder->toArray()
            ]
        )->send();
    }
}

// EOF
