<?php


namespace Avent\Core\Event;

use League\Event\EmitterInterface;

/**
 * Class EventEmitterAwareTrait
 * @package Avent\Core\Event
 */
trait EventEmitterAwareTrait
{
    /**
     * @var EmitterInterface
     */
    protected $emitter;

    /**
     * @param EmitterInterface $emitter
     */
    public function setEventEmitter(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * @return EmitterInterface
     */
    public function getEventEmitter()
    {
        return $this->emitter;
    }
}

// EOF
