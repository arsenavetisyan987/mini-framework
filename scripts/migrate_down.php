<?php

require_once __DIR__ . '/bootstrap.php';

use App\Models\BaseModel;

$last = BaseModel::lastMigration();

if (!$last) {
    echo "No migrations to rollback.\n";
    exit;
}

$migrationsDir = dirname(__DIR__) . '/src/Core/Database/Migrations';

$file = "$migrationsDir/$last.php";

if (!file_exists($file)) {
    echo "❌ Migration file not found: $last\n";
    exit;
}

require_once $file;

$parts = explode('_', $last);
array_shift($parts);
$classPart = implode('_', $parts);
$className = str_replace(' ', '', ucwords(str_replace('_', ' ', $classPart)));

$fqcn = "App\\Core\\Database\\Migrations\\$className";

if (!class_exists($fqcn)) {
    echo "❌ Migration class not found: $fqcn\n";
    exit;
}

echo "⏬ Rolling back: $fqcn\n";

$fqcn::down();
BaseModel::deleteMigration($last);

echo "✔ Rolled back: $last\n";