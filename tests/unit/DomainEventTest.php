<?php

class DomainEventTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testDomainEvent()
    {
        $event = new \Avent\Core\Event\EventEmitter();

        $event->addListener(
            \Avent\Core\Event\EventEmitter::AFTER_USER_REGISTRATION,
            function (
                \League\Event\EventInterface $event,
                \Avent\CommandBus\Command\UserRegistrationCommand $command = null){
                $this->assertInstanceOf(
                    "\\Avent\\CommandBus\\Command\\UserRegistrationCommand",
                    $command
                );
            }
        );

       $event->emit(
           \Avent\Core\Event\EventEmitter::AFTER_USER_REGISTRATION,
           new \Avent\CommandBus\Command\UserRegistrationCommand());
    }

}