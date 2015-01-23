<?php


namespace Avent\Core\Logger;

use Monolog\Logger;

trait LoggerAwareTrait
{
    protected $logger;

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }
}

// EOF
