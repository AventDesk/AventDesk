<?php


namespace Avent\Core\Controller;

use Avent\Core\EntityManager\EntityManagerAwareInterface;
use Avent\Core\EntityManager\EntityManagerAwareTrait;
use Avent\Core\Event\EventEmitterAwareInterface;
use Avent\Core\Event\EventEmitterAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use League\Event\EmitterInterface;

abstract class ControllerAbstract implements EntityManagerAwareInterface, EventEmitterAwareInterface
{
    use EntityManagerAwareTrait;
    use EventEmitterAwareTrait;

    public function __construct(EntityManagerInterface $em, EmitterInterface $event)
    {
        $this->setEventEmitter($event);
        $this->setEntityManager($em);
    }
}

// EOF
