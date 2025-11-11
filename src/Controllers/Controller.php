<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;

class Controller
{
    protected function view(string $name, array $data = []): Response
    {
        $viewPath = dirname(__DIR__) . "/Views/{$name}.php";

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
