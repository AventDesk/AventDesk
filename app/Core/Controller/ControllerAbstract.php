<?php


namespace Avent\Core\Controller;

use Avent\Core\ConfigAwareInterface;
use Avent\Core\ConfigAwareTrait;
use Avent\Core\EntityManager\EntityManagerAwareInterface;
use Avent\Core\EntityManager\EntityManagerAwareTrait;
use Avent\Core\Event\EventEmitterAwareInterface;
use Avent\Core\Event\EventEmitterAwareTrait;
use Avent\Core\Logger\LoggerAwareInterface;
use Avent\Core\Logger\LoggerAwareTrait;

abstract class ControllerAbstract implements
    EntityManagerAwareInterface,
    EventEmitterAwareInterface,
    ConfigAwareInterface,
    LoggerAwareInterface
{
    use EntityManagerAwareTrait;
    use EventEmitterAwareTrait;
    use ConfigAwareTrait;
    use LoggerAwareTrait;
}

// EOF
