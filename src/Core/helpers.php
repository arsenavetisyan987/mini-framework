<?php

declare(strict_types=1);

use App\Core\Response;

use Psr\Log\LoggerInterface;

if (!function_exists('view')) {
    function view(string $name, array $data = []): Response
    {
        $viewPath = dirname(__DIR__) . "/views/{$name}.php";

        if (!file_exists($viewPath)) {
            return new Response("View {$name} not found", 404);
        }

        extract($data);
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        return new Response($content);
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }
}

if (!function_exists('logger')) {
    function logger(): LoggerInterface
    {
        global $container;
        return $container->get(LoggerInterface::class);
    }
}