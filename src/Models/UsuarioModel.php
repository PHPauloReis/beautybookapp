<?php

namespace App\Models;

class UsuarioModel extends BaseModel
{
    protected string $table = "usuarios";

    public function obterPorEmail(string $email): array
    {
        $usuario = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->table)
            ->where("email = :email")
            ->setParameter("email", $email)
            ->executeQuery()
            ->fetchAssociative();

        if (!$usuario) {
            throw new \Exception("Usuário não encontrado");
        }

        return $usuario;
    }
}