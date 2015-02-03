<?php

class UserRegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    protected function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();
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