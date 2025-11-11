<?php

declare(strict_types=1);

namespace App\Core;

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{

    public const DEBUG = 'DEBUG';
    public const INFO  = 'INFO';
    public const ERROR = 'ERROR';
    public const ALERT = 'ALERT';
    public const WARNING = 'WARNING';

    public function __construct(private string $logFile)
    {
        $dir = dirname($logFile);

        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new \RuntimeException("Cannot create log directory: {$dir}");
        }

        if (!is_writable($dir)) {
            throw new \RuntimeException("Log directory is not writable: {$dir}");
        }
    }

    public function log($level, $message, array $context = []): void
    {
        $date = date('Y-m-d H:i:s');

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }

        $context['ip'] = $ip;

        $contextString = !empty($context) ? json_encode($context) : '';
        $formatted = "[{$date}] {$level}: {$message} {$contextString}" . PHP_EOL;

        file_put_contents($this->logFile, $formatted, FILE_APPEND);
    }

    public function debug($message, array $context = []): void
    {
        $this->log(self::DEBUG, $message, $context);
    }

    public function info($message, array $context = []): void
    {
        $this->log(self::INFO, $message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->log(self::ERROR, $message, $context);
    }
}