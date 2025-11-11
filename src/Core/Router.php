<?php

declare(strict_types=1);

namespace App\Core;

use Closure;
use Exception;

class Router
{
    protected static array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    public static function get(string $path, callable|array $action): void
    {
        self::$routes['GET'][$path] = $action;
    }

    public static function post(string $path, callable|array $action): void
    {
        self::$routes['POST'][$path] = $action;
    }

    public static function put(string $path, callable|array $action): void
    {
        self::$routes['PUT'][$path] = $action;
    }

    public static function patch(string $path, callable|array $action): void
    {
        self::$routes['PATCH'][$path] = $action;
    }

    public static function delete(string $path, callable|array $action): void
    {
        self::$routes['DELETE'][$path] = $action;
    }

    /**
     * @throws Exception
     */
    public static function dispatch(Request $request, Container $container): Response
    {
        $method = $request->method();
        $path   = $request->path();

        $action = self::$routes[$method][$path] ?? null;

        if ($action === null) {
            return new Response("<h1>404 Not Found</h1>", 404);
        }

        if ($action instanceof Closure) {
            $result = $action($request);
            return $result instanceof Response ? $result : new Response((string)$result);
        }

        if (is_array($action) && count($action) === 2) {
            [$controllerClass, $methodName] = $action;
            $controller = $container->make($controllerClass);

            $result = $controller->$methodName($request);

            return $result instanceof Response ? $result : new Response((string)$result);
        }

        return new Response("<h1>500 Invalid route definition</h1>", 500);
    }
}