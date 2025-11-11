<?php

declare(strict_types=1);

namespace App\Config;

use App\Core\ConfigInterface;

class AppConfig implements ConfigInterface
{
    protected array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 2) . '/config/app.php';
    }

    public static function key(): string
    {
        return 'app';
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function getAll(): array
    {
        return $this->config;
    }
}