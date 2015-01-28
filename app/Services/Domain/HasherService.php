<?php


namespace Avent\Services\Domain;

class HasherService
{
    public function hash($string)
    {
        return password_hash($string, PASSWORD_BCRYPT, ["cost" => 5]);
    }
}

// EOF
