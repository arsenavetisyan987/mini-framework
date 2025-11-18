<?php

declare(strict_types=1);

namespace App;

use App\Controllers\HomeController;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;

class Routes
{
    public static function register(): void
    {
        Router::get('/', [HomeController::class, 'index']);

        Router::get('/hello', function () {
            return new Response("<h1>Hello world</h1>");
        });

        Router::post('/api/data', function (Request $request) {
            return Response::json([
                'message' => 'Data received',
                'data' => $request->all()
            ]);
        });
    }
}