<?php

class CompanyCreatorServiceTest extends \PHPUnit_Framework_TestCase
{

    private $app;

    public function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();

        $repository_mock = \Codeception\Util\Stub::make("\\Avent\\Repository\\CompanyRepository", [
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

        $this->app->getContainer()->singleton("CompanyRepository", $repository_mock);
        $this->app->getContainer()->singleton("EntityManager", $em_mock);

        $this->app->getContainer()->singleton("Avent\\Services\\Domain\\CompanyCreatorService")
            ->withArgument("CompanyRepository")
            ->withArgument("EventEmitter")
            ->withArgument("ValidatorService");

        $this->app->registerCommandHandler("Avent\\CommandBus\\Handler\\CompanyCreatorHandler");
    }

    public function tearDown()
    {

    }

    public function testCompanyCreatorService()
    {
        $handler = $this->app->getContainer()->get("Avent\\CommandBus\\Handler\\CompanyCreatorHandler");

        $command = new \Avent\CommandBus\Command\CompanyCreatorCommand();

        $command->setCompanyPhone(123456789);
        $command->setEmail("john@doe.com");
        $command->setSocial(new \Avent\ValueObject\Social());
        $command->setAddress(new \Avent\ValueObject\Address());
        $command->setCompanyName("Acme, Inc.");

        $response = $handler->handle($command);

        $array_response = json_decode($response->getContent());

        $this->assertSame("Acme, Inc.", $array_response->data->company_name);
    }
}

// EOF
