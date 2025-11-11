<?php

declare(strict_types=1);

namespace App\Core;

use DirectoryIterator;
use ReflectionClass;
use RuntimeException;

class Config
{
    protected array $configs = [];

    public function __construct()
    {
        $configNamespace = 'App\\Config';
        $configPath = __DIR__ . '/../Config';

        if (!is_dir($configPath)) {
            throw new RuntimeException("Config directory not found: {$configPath}");
        }

        foreach (new DirectoryIterator($configPath) as $file) {
            if ($file->isDot() || $file->getExtension() !== 'php') {
                continue;
            }

            $className = $configNamespace . '\\' . $file->getBasename('.php');

            if (!class_exists($className)) {
                require_once $file->getPathname();
            }

            try {
                $reflection = new ReflectionClass($className);
            } catch (\Throwable $e) {
                continue;
            }

            if (!$reflection->implementsInterface(ConfigInterface::class)) {
                continue;
            }

            $this->configs[$className::key()] = $reflection->newInstance();
        }
    }

    public function get(string $configKey, string $key = '', mixed $default = null): mixed
    {
        if (!isset($this->configs[$configKey])) {
            throw new RuntimeException("Config '{$configKey}' not found.");
        }

        return $this->configs[$configKey]->get($key, $default);
    }

    public function all(string $configKey): array
    {
        if (!isset($this->configs[$configKey])) {
            throw new RuntimeException("Config '{$configKey}' not found.");
        }

        return $this->configs[$configKey]->getAll();
    }

    public function allConfigs(): array
    {
        return array_map(fn($config) => $config->getAll(), $this->configs);
    }
}
