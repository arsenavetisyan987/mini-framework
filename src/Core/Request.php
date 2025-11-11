<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    public function __construct(
        public array $get = [],
        public array $post = [],
        public array $server = [],
        public array $files = [],
        public array $cookies = [],
        public array $inputRaw = []
    ) {}

    public static function capture(): self
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $inputRaw = [];

        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH', 'DELETE']) &&
            str_contains(strtolower($contentType), 'application/json')) {
            $json = json_decode(file_get_contents('php://input'), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $inputRaw = $json;
            }
        }

        return new self(
            $_GET,
            $_POST,
            $_SERVER,
            $_FILES,
            $_COOKIE,
            $inputRaw
        );
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? "GET");
    }

    public function path(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $pos = strpos($uri, '?');

        return $pos === false ? $uri : substr($uri, 0, $pos);
    }

    public function input(string $key, mixed $default = false): mixed
    {
        return $this->post[$key]
            ?? $this->get[$key]
            ?? $this->inputRaw[$key]
            ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post, $this->inputRaw);
    }

    public function isJson(): bool
    {
        return str_contains(
            strtolower($this->server['CONTENT_TYPE'] ?? ''),
            'application/json'
        );
    }
}