<?php

declare(strict_types=1);

namespace App\Core\Database;

interface MigrationInterface
{
    public static function up(): void;
    public static function down(): void;
}