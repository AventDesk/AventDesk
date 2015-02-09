<?php

class PasswordReminderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Avent\Core\Application $app
     */
    private $app;

    public function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();

        $person_repo_mock = \Codeception\Util\Stub::make(
            "\\Avent\\Repository\\PersonRepository",
            [
                "findOneBy" => function () {
                    $person = new \Avent\Entity\Person();
                    $person->setEmail("john@doe.com");
                    return $person;
                }
            ]
        );

        $password_remind_repo = \Codeception\Util\Stub::make(
            "\\Avent\\Repository\\PasswordReminderRepository",
            [
                "save" => function () {
                    $password_remind = new \Avent\Entity\PasswordReminder();
                    $password_remind->setCode("1234567890");
                    return $password_remind;
                }
            ]
        );

        $event_mock = \Codeception\Util\Stub::make("\\Avent\\Core\\Event\\EventEmitter", [
            "emit" => function () {
                return true;
            }
        ]);

        $this->app->getContainer()->singleton("PersonRepository", $person_repo_mock);
        $this->app->getContainer()->singleton("PasswordReminderRepository", $password_remind_repo);
        $this->app->getContainer()->singleton("EventEmitter", $event_mock);

        $this->app->getContainer()->singleton("Avent\\Services\\Domain\\PasswordReminderService")
            ->withArgument("PasswordReminderRepository")
            ->withArgument("PersonRepository")
            ->withArgument("EventEmitter")
            ->withArgument("ValidatorService");

        $this->app->registerCommandHandler("Avent\\CommandBus\\Handler\\PasswordReminderHandler");
    }

    public function tearDown()
    {

    }

    public function testPasswordReminderService()
    {
        $handler = $this->app->getContainer()->get("Avent\\CommandBus\\Handler\\PasswordReminderHandler");

        $command = new \Avent\CommandBus\Command\PasswordReminderCommand();

        $command->setEmail("john@doe.com");

        $response = $handler->handle($command);

        $array_response = json_decode($response->getContent());

        $this->assertSame("1234567890", $array_response->data->code);
    }
}

// EOF
