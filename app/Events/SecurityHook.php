<?php


namespace Avent\Events;

use Avent\Core\Event\Abstraction\BeforeDispatchAbstract;
use League\Event\EventInterface;

/**
 * Class SecurityHook
 * @package Avent\Events
 */
class SecurityHook extends BeforeDispatchAbstract
{

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event)
    {

    }
}

// EOF
