<?php

namespace App\Models;

class UsuarioModel extends BaseModel
{
    protected string $table = "usuarios";
    protected array $fillable = ["nome", "email", "senha", "token_recuperacao_senha"];

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

    public function obterPorTokenRecuperacaoSenha(string $token): array
    {
        $usuario = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->table)
            ->where("token_recuperacao_senha = :token")
            ->setParameter("token", $token)
            ->executeQuery()
            ->fetchAssociative();

        if (!$usuario) {
            throw new \Exception("Token de recuperação de senha inválido");
        }

        return $usuario;
    }
}