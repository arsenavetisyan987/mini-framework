<?php

declare(strict_types=1);

namespace App\Models;

class User extends BaseModel
{
    protected static string $table = 'users';

    public static function all(): array
    {
        return self::fetchAll("SELECT * FROM " . self::$table);
    }

    public static function find(int $id): ?array
    {
        return self::fetchOne("SELECT * FROM " . self::$table . " WHERE id = :id", ['id' => $id]);
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO " . self::$table . " (name, email) VALUES (:name, :email)";
        self::execute($sql, $data);
        return (int) self::lastInsertId();
    }

    public static function delete(int $id): int
    {
        return self::execute("DELETE FROM " . self::$table . " WHERE id = :id", ['id' => $id]);
    }
}