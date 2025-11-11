<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Config\DatabaseConfig;
use PDOException;
use PDO;

class Connection
{
    private PDO $pdo;

    public function __construct()
    {
        $config = new DatabaseConfig();

        $driver   = $config->get('driver', 'mysql');
        $host     = $config->get('host', 'localhost');
        $port     = $config->get('port', 3306);
        $database = $config->get('database', 'framework');
        $username = $config->get('username', 'root');
        $password = $config->get('password', 'root');

        if ($driver === 'pgsql') {
            $dsn = sprintf('%s:host=%s;port=%s;dbname=%s', $driver, $host, $port, $database);
        } else {
            $dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=utf8', $driver, $host, $port, $database);
        }

        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}