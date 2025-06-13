<?php

namespace app\dataBase\Models;

use app\dataBase\connection;

class User extends Model
{
    protected string $tables = 'usuarios';

    public function authenticate(string $email, string $password)
    {
        try {
            // Verifica se é um login de administrador
            if ($email === 'admin') {
                $query = connection::connect()->prepare("SELECT * FROM {$this->tables} WHERE username = :username");
                $query->execute([':username' => $email]);
            } else {
                // Login normal por email
                $query = connection::connect()->prepare("SELECT * FROM {$this->tables} WHERE email = :email");
                $query->execute([':email' => $email]);
            }

            $user = $query->fetch(\PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['senha'])) {
                unset($user['senha']); // Remove a senha do array antes de retornar
                return $user;
            }

            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
