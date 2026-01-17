<?php

namespace App\Models;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ManicureModel
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = DriverManager::getConnection([
            "dbname" => "beautybook",
            "user" => "root",
            "password" => "root",
            "host" => "localhost",
            "driver" => "pdo_mysql",
            "charset" => "utf8mb4",
        ]);
    }

    public function obterTodas(): array
    {
        $registros = $this->connection->createQueryBuilder()
            ->select("*")
            ->from("manicures")
            ->executeQuery()
            ->fetchAllAssociative();

        return $registros;
    }
}