<?php


namespace Avent\Core\Logger\Handler;

use Monolog\Formatter\LineFormatter;

/**
 * Class BrowserConsoleHandler
 * @package Avent\Core\Logger\Handler
 */
class BrowserConsoleHandler implements HandlerInterface
{
    /**
     * @param LineFormatter $formatter
     * @param array $config
     * @param bool|int $log_level
     * @return \Monolog\Handler\BrowserConsoleHandler
     */
    public static function create(LineFormatter $formatter, array $config, $log_level)
    {
        $handler = new \Monolog\Handler\BrowserConsoleHandler();
        $handler->setFormatter($formatter);
        return $handler;
    }
}

// EOF
