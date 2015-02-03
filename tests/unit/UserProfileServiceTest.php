<?php

class UserProfileServiceTest extends \PHPUnit_Framework_TestCase
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
