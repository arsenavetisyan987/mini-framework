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
}
