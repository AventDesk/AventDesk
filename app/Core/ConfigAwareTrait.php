<?php


namespace Avent\Core;

trait ConfigAwareTrait
{
    /**
     * @var
     */
    protected $config;

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }


}