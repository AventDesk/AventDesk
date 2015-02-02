<?php

class UserRegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    protected function setUp()
    {
        // Define Depencencies
        $repository_mock = \Codeception\Util\Stub::make("\\Avent\\Repository\\PersonRepository", [
            "save" => function () {
                return true;
            },
            "findOneBy" => function () {
                return true;
            }
        ]);

        $em_mock = \Codeception\Util\Stub::make("\\Doctrine\\ORM\\EntityManager", [
            "getRepository" => $repository_mock
        ]);

        $event_mock = \Codeception\Util\Stub::make("\\Avent\\Core\\Event\\EventEmitter", [
            "emit" => function () {
                return true;
            }
        ]);

        $hasher_mock = \Codeception\Util\Stub::make("\\Avent\\Services\\Domain\\HasherService", [
            "hash" => function () {
                return "12345";
            }
        ]);

        $app = new \Avent\Core\Application();
        $app->getContainer()->singleton("PersonRepository", $repository_mock);
        $app->getContainer()->singleton("EventEmitter", $event_mock);
        $app->getContainer()->singleton("EntityManager", $em_mock);
        $app->getContainer()->singleton("HasherService", $hasher_mock);

        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
            "Symfony\\Component\\Validator\\Constraint",
            __DIR__ . "/../../vendor/symfony/validator"
        );

        // services
        $app->getContainer()->singleton("Avent\\Services\\Domain\\UserRegistrationService")
            ->withArgument("PersonRepository")
            ->withArgument("EventEmitter")
            ->withArgument("Validator")
            ->withArgument("HasherService");

        // Services factory
        $app->getContainer()->singleton("DomainServicesFactory", function() use ($app) {
            return new \Avent\Services\DomainServiceFactory($app->getContainer());
        });

        $app->getContainer()->singleton("InfrastructureServicesFactory", function () use ($app) {
            return new \Avent\Services\InfrastructureServiceFactory($app->getContainer());
        });

        // Define Handler
        $app->registerCommandHandler("Avent\\CommandBus\\Handler\\UserRegistrationHandler");

        $this->app = $app;
    }

    protected function tearDown()
    {
    }

    // tests
    public function testUserRegistrationService()
    {
        $handler = $this->app->getContainer()->get("Avent\\CommandBus\\Handler\\UserRegistrationHandler");

        $command = new \Avent\CommandBus\Command\UserRegistrationCommand();

        $command->setEmail("john@doe.com");

        $response = $handler->handle($command);

        $array_response = json_decode($response->getContent());

        $this->assertSame("john@doe.com", $array_response->data->email);
    }
}