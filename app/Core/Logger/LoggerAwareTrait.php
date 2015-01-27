<?php


namespace Avent\Core\Logger;

use Monolog\Logger;

/**
 * Class LoggerAwareTrait
 * @package Avent\Core\Logger
 */
trait LoggerAwareTrait
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * {@inheritdoc}
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogger()
    {
        return $this->logger;
    }
}

// EOF
