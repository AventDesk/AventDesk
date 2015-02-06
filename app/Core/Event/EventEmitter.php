<?php


namespace Avent\Core\Event;

use Avent\Core\Event\Exception\InvalidEventNameException;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Event\Emitter;
use League\Event\EventInterface;

/**
 * Class EventEmitter
 * @package Avent\Core\Event
 */
class EventEmitter extends Emitter implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    const BEFORE_APP = "before.app";
    /**
     * @var string
     */
    const AFTER_APP = "after.app";
    /**
     * @var string
     */
    const BEFORE_DISPATCH = "before.dispatch";
    /**
     * @var string
     */
    const AFTER_DISPATCH = "after.dispatch";
    /**
     * @var string
     */
    const ON_ERROR = "on.error";
    /**
     * @var string
     */
    const BEFORE_USER_REGISTRATION = "before.user.Registration";
    /**
     * @var string
     */
    const AFTER_USER_REGISTRATION = "after.user.registration";
    /**
     * @var string
     */
    const SECURITY_EVENT = "security.event";

    /**
     * @param string $event
     * @param string $listener
     * @param int $priority
     * @return $this
     * @throws InvalidEventNameException
     */
    public function addListener($event, $listener, $priority = self::P_NORMAL)
    {
        $class_reflection = new \ReflectionClass("Avent\\Core\\Event\\EventEmitter");
        $event_names = $class_reflection->getConstants();

        if (!in_array($event, $event_names) && !($event == "*")) {
            throw new InvalidEventNameException("Event name {$event} is not valid");
        }

        if (! isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = [$listener, $priority];
        $this->clearSortedListeners($event);
    }

    /**
     * {@inheritdoc}
     */
    public function emit($event)
    {
        list($name, $event) = $this->prepareEvent($event);
        $arguments = [$event] + func_get_args();

        $this->invokeListeners($name, $event, $arguments);
        $this->invokeListeners("*", $event, $arguments);

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    protected function invokeListeners($name, EventInterface $event, array $arguments)
    {
        $listeners = $this->getListeners($name);

        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }

            $listener = $this->getContainer()->get($listener);

            $this->ensureListener($listener);

            call_user_func_array([$listener, "handle"], $arguments);
        }
    }
}

// EOF
