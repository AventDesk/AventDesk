<?php


namespace Avent\Core\Event;

/**
 * Class IsListenerTrait
 * @package Avent\Core\Event
 */
trait IsListenerTrait
{
    /**
     * @param $listener
     * @return bool
     */
    public function isListener($listener)
    {
        return $listener === $this;
    }
}

// EOF
