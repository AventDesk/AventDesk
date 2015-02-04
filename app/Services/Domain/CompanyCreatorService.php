<?php


namespace Avent\Services\Domain;

use Avent\CommandBus\Command\CompanyCreatorCommand;
use Avent\Core\CommandBus\CommandInterface;
use Avent\Core\Event\EventEmitter;
use Avent\Core\Services\DomainServiceInterface;
use Avent\Entity\Company;
use Avent\Repository\CompanyRepository;
use Avent\Response\ApiResponse;
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
        if (! $command instanceof CompanyCreatorCommand) {
            throw new \Exception(get_class($command) . "must be an instance of UserRegistration Command");
        }

        $this->event_emitter->emit("before.create.company", $command);

        $command->setRepository($this->repository);

        $response = ApiResponse::create();

        try {
            if ($violation = $this->validator->validate($command)) {
                throw new \InvalidArgumentException("Validation error");
            }

            $company = new Company();
            $company->setSocial($command->getSocial());
            $company->setAddress($command->getAddress());
            $company->setEmail($command->getEmail());
            $company->setCompanyName($command->getCompanyName());
            $company->setPhone($command->getCompanyPhone());

            $this->repository->save($company);

            $this->event_emitter->emit("after.create.company", $command);
            return $response->withArray([
                "message" => "Company created successfully",
                "data" => $company->toArray()
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
