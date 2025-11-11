<?php

require_once __DIR__ . '/bootstrap.php';

$migrationsDir = dirname(__DIR__) . '/src/Core/Database/Migrations';

foreach (glob($migrationsDir . '/*.php') as $file) {

    require_once $file;
    $baseName = pathinfo($file, PATHINFO_FILENAME);
    $className = "App\\Core\\Database\\migrations\\$baseName";

    $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $className)));

    if (class_exists($className)) {
        echo "Running migration: $className\n";
        $className::up();
    } else {

        echo "⚠️ Class $className not found in $file\n";
    }
}