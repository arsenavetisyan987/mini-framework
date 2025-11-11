<?php

declare(strict_types=1);

namespace App\Core\Database\Migrations;

use App\Core\Database\MigrationInterface;
use App\Models\BaseModel;

class CreateUsersTable implements MigrationInterface
{
    public static function up(): void
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";

        try {
            BaseModel::execute($sql);
            echo "✅ Created table: users\n";
        } catch (\PDOException $e) {
            echo "❌ Failed to create table: " . $e->getMessage() . "\n";
        }
    }

    public static function down(): void
    {
        try {
            BaseModel::execute("DROP TABLE IF EXISTS users;");
            echo "❌ Dropped table: users\n";
        } catch (\PDOException $e) {
            echo "❌ Failed to drop table: " . $e->getMessage() . "\n";
        }
    }
}