<?php


namespace Avent\Core\Event;

use League\Event\EmitterInterface;

/**
 * Interface EventEmitterAwareInterface
 * @package Avent\Core\Event
 */
interface EventEmitterAwareInterface
{
    /**
     * @param EmitterInterface $emitter
     * @return void
     */
    public function setEventEmitter(EmitterInterface $emitter);

    /**
     * @return EmitterInterface
     */
    public function getEventEmitter();
}

// EOF
