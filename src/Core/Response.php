<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public function __construct(
        protected string $content,
        protected int $status = 200,
        protected array $headers = ['Content-Type' => 'text/html; charset=utf-8'],
    ) {}

    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $header => $value) {
            header($header . ': ' . $value);
        }

        echo $this->content;
    }

    public static function json(array $data, int $status = 200): self
    {
        return new self(
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            $status,
            ['Content-Type' => 'application/json']
        );
    }
}