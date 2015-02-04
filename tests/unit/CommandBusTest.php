<?php

class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    protected function setUp()
    {
        $this->app = \Avent\Core\Application::getInstance();

        $this->app->registerCommandHandler("Avent\\Stubs\\HandlerStub");
    }

    protected function tearDown()
    {
    }

    // tests
    public function testCommandBus()
    {
        $command_bus = new \Avent\Core\CommandBus\CommandBus(
            $this->app->getContainer(),
            new \Avent\Core\CommandBus\NameInflector()
        );

        $result = $command_bus->execute(new \Avent\Stubs\CommandStub());

        $this->assertTrue($result);
    }

}