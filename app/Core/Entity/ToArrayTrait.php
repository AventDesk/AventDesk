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
        $vars = get_object_vars($this);

        $data = [];
        foreach ($vars as $key => $value) {
            $data[] = [
                $key => $value
            ];
        }

        return $data;
    }
}

// EOF
