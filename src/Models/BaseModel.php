<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database\Connection;
use PDO;

abstract class BaseModel
{
    protected static PDO $db;

    public static function setConnection(Connection $connection): void
    {
        self::$db = $connection->getPdo();

        self::$db->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    public static function getConnection(): PDO
    {
        return self::$db;
    }

    public static function execute(string $sql, array $params = []): int
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    protected static function fetchAll(string $sql, array $params = []): array
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    protected static function lastInsertId(): string
    {
        return self::$db->lastInsertId();
    }

    public static function executedMigrations(): array
    {
        $stmt = self::$db->query("SELECT name FROM migrations ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function saveMigration(string $name): void
    {
        $stmt = self::$db->prepare("INSERT INTO migrations (name) VALUES (?)");
        $stmt->execute([$name]);
    }

    public static function deleteMigration(string $name): void
    {
        $stmt = self::$db->prepare("DELETE FROM migrations WHERE name = ?");
        $stmt->execute([$name]);
    }

    public static function lastMigration(): ?string
    {
        $stmt = self::$db->query("SELECT name FROM migrations ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        return $result === false ? null : $result;
    }
}
