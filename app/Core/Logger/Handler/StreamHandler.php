<?php


namespace Avent\Core\Logger\Handler;

use Monolog\Formatter\LineFormatter;

/**
 * Class StreamHandler
 * @package Avent\Core\Logger\Handler
 */
class StreamHandler implements HandlerInterface
{
    /**
     * @param LineFormatter $formatter
     * @param array $config
     * @param bool|int $log_level
     * @return \Monolog\Handler\StreamHandler
     */
    public static function create(LineFormatter $formatter, array $config, $log_level)
    {
        if ($config["rotate"]) {
            $file_name = APP_PATH . "/Writeable/Logs/ " . date("Y-m-d") . ".log";
        } else {
            $file_name = APP_PATH . "/Writeable/Logs/app.log";
        }

        $handler = new \Monolog\Handler\StreamHandler($file_name, $log_level);
        $handler->setFormatter($formatter);

        return $handler;
    }
}

// EOF
