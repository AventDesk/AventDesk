<?php


namespace Avent\Core\Logger\Handler;

use Monolog\Formatter\LineFormatter;

/**
 * Interface HandlerInterface
 * @package Avent\Core\Logger\Handler
 */
interface HandlerInterface
{
    /**
     * @param LineFormatter $formatter
     * @param array $config
     * @param integer|bool $log_level
     */
    public static function create(LineFormatter $formatter, array $config, $log_level);
}

// EOF
