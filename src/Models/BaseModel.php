<?php

namespace App\Models;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class BaseModel
{
    protected Connection $connection;

    protected string $table = "";
    protected array $fillable = [];

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
            ->from($this->table)
            ->executeQuery()
            ->fetchAllAssociative();

        return $registros;
    }

    public function obterTodasComFiltro(string $busca): array
    {
        $registros = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->table)
            ->where("nome LIKE :busca")
            ->orWhere("telefone LIKE :busca")
            ->orWhere("especialidade LIKE :busca")
            ->setParameter("busca", "%" . $busca . "%")
            ->executeQuery()
            ->fetchAllAssociative();

        return $registros;
    }

    public function gravar(array $dados): void
    {
        $dadosFiltrados = $this->filtrarCampos($dados);

        $this->connection->insert($this->table, $dadosFiltrados);
    }

    public function excluir(int $id): void
    {
        $this->connection->delete($this->table, ["id" => $id]);
    }

    protected function filtrarCampos(array $dados): array
    {
        return array_filter(
            $dados, 
            fn($key) => in_array($key, $this->fillable), 
            ARRAY_FILTER_USE_KEY
        );
    }
}