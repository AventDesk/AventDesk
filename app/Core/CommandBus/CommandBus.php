<?php


namespace Avent\Core\CommandBus;

use League\Container\ContainerInterface;

/**
 * Class CommandBus
 * @package Avent\Core\CommandBus
 */
class CommandBus
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var InflectorInterface
     */
    private $inflector;

    /**
     * @param ContainerInterface $container
     * @param InflectorInterface $inflector
     */
    public function __construct(ContainerInterface $container, InflectorInterface $inflector)
    {
        $this->container = $container;
        $this->inflector = $inflector;
    }

    /**
     * @param CommandInterface $command
     * @return mixed
     */
    public function execute(CommandInterface $command)
    {
        return $this->handler($command)->handle($command);
    }

    /**
     * @param CommandInterface $command
     * @return mixed
     */
    private function handler(CommandInterface $command)
    {
        $class = $this->inflector->inflect($command);

        return $this->container->get($class);
    }
}

// EOF
