<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Core/helpers.php';

use App\Core\Application;

try {
    $app = new Application(dirname(__DIR__));
    $app->run();
} catch (Exception $e) {
    echo $errorMessage = $e->getMessage();
}

