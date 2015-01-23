<?php


namespace Avent\Core\Logger;


use Monolog\Logger;

/**
 * Interface LoggerAwareInterface
 * @package Avent\Core\Logger
 */
interface LoggerAwareInterface
{
    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger);

    /**
     * @return Logger
     */
    public function getLogger();
}

// EOF
