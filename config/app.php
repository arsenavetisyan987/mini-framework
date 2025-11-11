<?php

declare(strict_types=1);

namespace App\config;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | Used for titles, logs, and identification across the framework.
    |
    */
    'name' => 'MiniFramework',

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | Common values: local, staging, production.
    | You can use this to load different configs or enable debugging.
    |
    */
    'env' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | When true, all errors will be shown with detailed stack traces.
    | In production, set this to false.
    |
    */
    'debug' => true,

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | Used for generating URLs and links inside the app.
    |
    */
    'url' => 'http://localhost:8000',

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | Default timezone for date and time operations.
    |
    */
    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Path to log file and default log level.
    | You can override these values in LogFactory.
    |
    */
    'log_path' => dirname(__DIR__) . '/storage/logs/app.log',
    'log_level' => 'debug',
];

