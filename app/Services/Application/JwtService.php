<?php


namespace Avent\Services\Application;

/**
 * Class JwtService
 * @package Avent\Services\Application
 */
class JwtService
{
    /**
     * @var string
     */
    private $key;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param array|object $token
     * @return string
     */
    public function encode($token)
    {
        return \JWT::encode($token, $this->key);
    }

    /**
     * @param string $jwy
     * @return object
     */
    public function decode($jwy)
    {
        return \JWT::decode($jwy, $this->key);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
}

// EOF
