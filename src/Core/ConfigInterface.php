<?php

declare(strict_types=1);

namespace App\Core;

interface ConfigInterface
{
    public static function key(): string;
    public function get(string $key, mixed $default = null): mixed;
    public function getAll(): array;
}