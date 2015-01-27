<?php

class InflectorTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testNameInflector()
    {
        $command_stub = new \Avent\Stubs\CommandStub();
        $inflector = new \Avent\Core\CommandBus\NameInflector();

        $this->assertSame("Avent\\Stubs\\HandlerStub", $inflector->inflect($command_stub));
    }

}
