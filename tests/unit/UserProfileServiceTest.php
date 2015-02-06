<?php

class UserProfileServiceTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    protected function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();

        $repository_mock = \Codeception\Util\Stub::make("\\Avent\\Repository\\PersonRepository", [
            "save" => function () {
                return true;
            },
            "findOneBy" => function () {
                return true;
            },
            "findOneByPersonId" => function () {
                return new \Avent\Entity\Person();
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

        $this->app->getContainer()->singleton("EventEmitter", $event_mock);
        $this->app->getContainer()->singleton("PersonRepository", $repository_mock);
        $this->app->getContainer()->singleton("EntityManager", $em_mock);
        
        $this->app->getContainer()->singleton("Avent\\Services\\Domain\\UserProfileService")
            ->withArgument("PersonRepository")
            ->withArgument("EventEmitter")
            ->withArgument("ValidatorService");

        $this->app->registerCommandHandler("Avent\\CommandBus\\Handler\\UserProfileHandler");
    }

    protected function tearDown()
    {
    }

    // tests
    public function testUserProfileService()
    {
        $handler = $this->app->getContainer()->get("Avent\\CommandBus\\Handler\\UserProfileHandler");

        $command = new \Avent\CommandBus\Command\UserProfileCommand();

        $command->setCity("Heaven");

        $response = $handler->handle($command);

        $array_response = json_decode($response->getContent());

        $this->assertSame("Heaven", $array_response->data->address->city);
    }
}

// EOF
