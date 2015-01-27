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
     * {@inheritdoc}
     */
    public function setEventEmitter(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventEmitter()
    {
        return $this->emitter;
    }
}

// EOF
