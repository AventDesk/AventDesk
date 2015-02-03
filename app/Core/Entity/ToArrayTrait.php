<?php


namespace Avent\Core\Entity;

use Avent\Core\ValueObject\ValueObjectInterface;

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
            if ($value instanceof ValueObjectInterface) {
                $properties = get_object_vars($value);
                $prop_array = new \ArrayObject();
                foreach ($properties as $property => $val) {
                    $prop_array->offsetSet($property, $val);
                }
                $array_object->offsetSet($key, $prop_array->getArrayCopy());
            } else {
                if (!is_object($value)) {
                    $array_object->offsetSet($key, $value);
                }
            }
        }

        return $array_object->getArrayCopy();
    }
}

// EOF
