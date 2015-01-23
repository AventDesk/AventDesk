<?php


namespace Avent\Core\Logger;

/**
 * Class HandlerCreator
 * @package Avent\Core\Logger
 */
class HandlerCreator
{
    /**
     * @param $name
     * @param $args
     * @return object
     */
    public function __callStatic($name, $args)
    {
        $class_name = "Avent\\Core\\Logger\\Handler\\{$name}";

        if (!class_exists($class_name)) {
            throw new \RuntimeException("{$class_name} couldn't found in system");
        }

        return $class_name::create($args[0], $args[1], $args[2]);
    }
}

// EOF
