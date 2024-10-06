<?php

namespace App\Shared\Infrastructure\Database;

use PDO;

class DatabaseConnectionService
{
    private PDO $pdo;

    public function __construct()
    {

        $host = $_ENV['MYSQL_HOST'];
        $db   = $_ENV['MYSQL_DATABASE'];
        $user = $_ENV['MYSQL_ROOT_USER'];
        $pass = $_ENV['MYSQL_ROOT_PASSWORD'];
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}