<?php

$name = $argv[1] ?? null;
if (!$name) exit("Usage: composer migrate-create create_users_table\n");

$timestamp = date('His');
$clean = strtolower($name);

$filename = "{$timestamp}_{$clean}.php";
$path = __DIR__ . '/../src/Core/Database/Migrations/' . $filename;

$className = str_replace(' ', '', ucwords(str_replace('_', ' ', $clean)));

$template = <<<PHP
<?php

namespace App\Core\Database\Migrations;

use App\Core\Database\MigrationInterface;

class {$className} implements MigrationInterface
{
    public static function up(): void
    {
    }

    public static function down(): void
    {
    }
}

PHP;

file_put_contents($path, $template);

echo "✔ Created migration: $filename (class: $className)\n";