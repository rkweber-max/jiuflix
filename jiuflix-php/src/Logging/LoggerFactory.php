<?php

namespace App\Logging;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class LoggerFactory {
    private static ?Logger $logger = null;

    public static function getLogger(): Logger {
        if (self::$logger === null) {
            $logger = new Logger('jiuflix');

            $handler = new StreamHandler(
                __DIR__ . '/../storage/logs/jiuflix.log',
                Level::Info
            );

            $handler->setFormatter(new JsonFormatter());
            $logger->pushHandler($handler);

            self::$logger = $logger;
        }

        return self::$logger;
    }
}