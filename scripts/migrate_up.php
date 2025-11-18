<?php

require_once __DIR__ . '/bootstrap.php';
use App\Models\BaseModel;


$dir = dirname(__DIR__) . '/src/Core/Database/Migrations';
$executed = BaseModel::executedMigrations();

$runOne = $argv[1] ?? null;

$files = glob($dir . '/*.php');
sort($files); // по времени

foreach ($files as $file) {
    $filename = pathinfo($file, PATHINFO_FILENAME);

    if ($runOne && stripos($filename, strtolower($runOne)) === false) {
        continue;
    }

    if (in_array($filename, $executed)) {
        echo "⏭ Skip: $filename\n";
        continue;
    }

    require_once $file;

    $parts = explode('_', $filename);
    array_shift($parts);
    $classBase = implode('_', $parts);
    $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $classBase)));

    $fullClass = "App\\Core\\Database\\Migrations\\$className";

    if (!class_exists($fullClass)) {
        echo "⚠️ Class $fullClass not found\n";
        continue;
    }

    echo "▶ Running: $fullClass\n";
    $fullClass::up();

    BaseModel::saveMigration($filename);
    echo "✔ Saved: $filename\n";

    if ($runOne) break;
}