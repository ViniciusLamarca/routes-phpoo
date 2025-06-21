<?php

namespace App\Database\Models;

use app\dataBase\connection;
use PDO;

class Login
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = connection::connect();
        } catch (\Exception $e) {
            error_log("Erro de conexão: " . $e->getMessage());
            throw new \Exception("Erro de conexão com o banco de dados");
        }
    }

    public function authenticate(string $identifier, string $password)
    {
        try {
            // Verificar se a tabela usuarios existe
            $stmt = $this->pdo->query("SHOW TABLES LIKE 'usuarios'");
            if ($stmt->rowCount() == 0) {
                error_log("Tabela 'usuarios' não encontrada");
                return null;
            }

            // Buscar por username ou email na tabela usuarios real
            $sql = "SELECT * FROM usuarios WHERE (email = :identifier OR username = :identifier) AND status = 'ativo' LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user && isset($user->senha)) {
                // Verificar senha (com hash)
                if (password_verify($password, $user->senha)) {
                    // Retornar dados no formato esperado pelo sistema
                    return (object) [
                        'id' => $user->id_usuario,
                        'id_usuario' => $user->id_usuario,
                        'username' => $user->username,
                        'nome' => $user->username, // Compatibilidade
                        'email' => $user->email,
                        'cargo' => $user->cargo,
                        'cpf' => $user->cpf,
                        'telefone' => $user->telefone,
                        'endereco' => $user->endereco,
                        'status' => $user->status,
                        'data_contratacao' => $user->data_contratacao
                    ];
                }
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erro na autenticação: " . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE id_usuario = :id AND status = 'ativo' LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return null;
        }
    }
}