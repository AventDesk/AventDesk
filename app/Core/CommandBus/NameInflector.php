<?php

namespace Avent\Core\CommandBus;

class NameInflector implements InflectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function inflect(CommandInterface $command)
    {
        return str_replace("Command", "Handler", get_class($command));
    }
}
