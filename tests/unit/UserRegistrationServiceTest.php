<?php

class UserRegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $em;

    protected $event_emitter;

    protected $validator;

    protected $hasher;

    protected function setUp()
    {
        $this->em = \Codeception\Util\Stub::make("\\Doctrine\\ORM\\EntityManager",
            [
                "getRepository" => \Codeception\Util\Stub::make("\\Avent\\Repository\\PersonRepository",
                    [
                        "save" => function () {
                            return true;
                        },
                        "findOneBy" => function () {
                            return new \Avent\Entity\Person();
                        }
                    ]
                ),
            ]
        );

        $this->event_emitter = \Codeception\Util\Stub::make("\\Avent\\Core\\Event\\EventEmitter", [
                "emit" => function () {
                    return true;
                }
            ]
        );

        $this->validator = \Symfony\Component\Validator\Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        $this->hasher = new \Avent\Services\Domain\HasherService();

        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
            "Symfony\\Component\\Validator\\Constraint",
            __DIR__ . "/../../vendor/symfony/validator"
        );
    }

    protected function tearDown()
    {
    }

    // tests
    public function testUserRegistrationService()
    {
        $repository = $this->em->getRepository("\\Avent\\Repository\\PersonRepository");

        $command = new \Avent\CommandBus\Command\UserRegistrationCommand();
        $command->setRepository($repository);

        $user_registration = new \Avent\Services\Domain\UserRegistrationService(
            $repository,
            $this->event_emitter,
            $this->validator,
            $this->hasher
        );

        $command->setEmail("me@info.net");
        $command->setPassword("1234");
        $response = $user_registration->register($command);

        $this->assertSame(\Symfony\Component\HttpFoundation\Response::HTTP_OK, $response->getStatusCode());
    }
}