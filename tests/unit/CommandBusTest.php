<?php

class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testCommandBus()
    {
        $container = new \League\Container\Container();
        $container->add("Avent\\Stubs\\HandlerStub");

        $command_bus = new \Avent\Core\CommandBus\CommandBus($container, new \Avent\Core\CommandBus\NameInflector());

        $result = $command_bus->execute(new \Avent\Stubs\CommandStub());

        $this->assertTrue($result);
    }

}