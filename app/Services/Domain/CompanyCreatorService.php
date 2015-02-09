<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\CompanyCreatorCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Services\DomainServiceInterface;
use Avent\Entity\Company;
use Avent\Repository\CompanyRepository;
use Avent\Response\ApiResponse;
use Avent\Services\Application\ValidatorService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CompanyCreatorService
 * @package Avent\Services\Domain
 */
class CompanyCreatorService implements DomainServiceInterface
{
    /**
     * @var CompanyRepository
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
     * @param CompanyRepository $repository
     * @param EventEmitter $event_emitter
     * @param ValidatorService $validator
     */
    public function __construct(
        CompanyRepository $repository,
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
        $command->setRepository($this->repository);

        if (! $command instanceof CompanyCreatorCommand) {
            throw new \DomainException(get_class($command) .
                "must be an instance of CompanyCreatorCommand Command");
        }

        if ($violation = $this->validator->validate($command)) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $company = new Company();
        $company->setSocial($command->getSocial());
        $company->setAddress($command->getAddress());
        $company->setEmail($command->getEmail());
        $company->setCompanyName($command->getCompanyName());
        $company->setPhone($command->getCompanyPhone());

        $this->repository->save($company);

        return ApiResponse::create()->withArray([
            "message" => "Company created successfully",
            "data" => $company->toArray()
        ])->send();
    }
}

// EOF
