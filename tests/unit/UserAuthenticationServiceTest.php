<?php

class UserAuthenticationServiceTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();

        $person_repository = \Codeception\Util\Stub::make(
            "\\Avent\\Repository\\PersonRepository",
            [
                "findOneBy" => function () {
                    $person = new \Avent\Entity\Person();
                    $person->setPersonId(1);
                    $person->setEmail("john@doe.com");
                    $person->setPassword(password_hash("123", PASSWORD_BCRYPT, ["cost" => 5]));
                    return $person;
                }
            ]
        );

        $api_key_repository = \Codeception\Util\Stub::make(
            "\\Avent\\Repository\\ApiKeyRepository",
            [
                "findOneBy" => function () {
                    $key = new \Avent\Entity\ApiKey();
                    $key->setApiKey("12345678");
                    return $key;
                },
                "save" => function () {
                    return true;
                }
            ]
        );

        $event_mock = \Codeception\Util\Stub::make("\\Avent\\Core\\Event\\EventEmitter", [
            "emit" => function () {
                return true;
            }
        ]);

        $this->app->getContainer()->singleton("PersonRepository", $person_repository);
        $this->app->getContainer()->singleton("ApiKeyRepository", $api_key_repository);
        $this->app->getContainer()->singleton("EventEmitter", $event_mock);

        $this->app->getContainer()->singleton("Avent\\Services\\Domain\\UserAuthenticationService")
            ->withArgument("PersonRepository")
            ->withArgument("ApiKeyRepository")
            ->withArgument("EventEmitter")
            ->withArgument("ValidatorService");

        $this->app->registerCommandHandler("Avent\\CommandBus\\Handler\\UserAuthenticationHandler");
    }

    public function tearDown()
    {

    }

    public function testUserAuthenticationService()
    {
        $handler = $this->app->getContainer()->get("Avent\\CommandBus\\Handler\\UserAuthenticationHandler");

        $command = new \Avent\CommandBus\Command\UserAuthenticationCommand();

        $command->setEmail("john@doe.com");
        $command->setPassword("123");

        $response = $handler->handle($command);

        $array_response = json_decode($response->getContent());

        $this->assertSame("12345678", $array_response->data->api_key);
    }
}

// EOF
