<?php


namespace Avent\Services\Application;

/**
 * Class HasherService
 * @package Avent\Services\Application
 */
class HasherService
{
    /**
     * @param $string
     * @return string
     */
    public function hash($string)
    {
        return password_hash($string, PASSWORD_BCRYPT, ["cost" => 5]);
    }
}

// EOF
