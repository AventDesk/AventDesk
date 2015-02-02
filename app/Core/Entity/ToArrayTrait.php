<?php


namespace Avent\Core\Entity;

/**
 * Class ToArrayTrait
 * @package Avent\Core\Entity
 */
trait ToArrayTrait
{
    /**
     * @return array
     */
    public function toArray()
    {
        $array_object = new \ArrayObject();

        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            $array_object->offsetSet($key, $value);
        }

        return $array_object->getArrayCopy();
    }
}

// EOF
