<?php

namespace app\dataBase\Models;

use app\dataBase\connection;
use PDOException;

class Register extends Model
{
    protected string $tables = 'users';

    public function create(array $data)
    {
        try {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['tipo_user'] = strtoupper($data['tipo_user']);

            $this->validate($data);

            $sql = "INSERT INTO {$this->tables} (nome, email, password, tipo_user) VALUES (:name, :email, :password, :tipo_user)";
            $query = connection::connect()->prepare($sql);
            $query->execute([
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':tipo_user' => $data['tipo_user'],
            ]);
            return header('location: http://localhost/PHP-POO/public/index.php');
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    private function validate(array $data)
    {
        if (empty($data['name'])) {
            throw new \Exception('Nome inválido');
        }
        if (empty($data['email'])) {
            throw new \Exception('Email inválido');
        }
        if (empty($data['password'])) {
            throw new \Exception('Password inválido');
        }
        if (empty($data['tipo_user'])) {
            throw new \Exception('Tipo de usuário inválido');
        }
        if ($this->validateUser($data)) {
            throw new \Exception('Usuário já cadastrado');
        }
    }

    private function validateUser(array $data)
    {
        $query = connection::connect()->prepare("SELECT * FROM users WHERE email = :email or nome = :name");
        $query->execute([':email' => $data['email'], ':name' => $data['name']]);
        return ($query->rowCount() > 0) ? true : false;
    }
}
