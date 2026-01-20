<?php

namespace App\Support;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class LoggerFactory
{
    public static function create(string $canal = "app"): Logger
    {
        $logger = new Logger($canal);
        $handler = new StreamHandler(__DIR__ . '/../../storage/logs/' . $canal . '.log', Level::Debug);
        $logger->pushHandler($handler);

        return $logger;
    }
}