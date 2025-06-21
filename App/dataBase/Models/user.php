<?php

namespace App\Database\Models;

class User extends BaseModel
{
    protected string $table = 'users';

    protected array $fillable = [
        'username',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected array $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function createUser(array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->create($data);
    }

    public function updatePassword(int $id, string $newPassword): bool
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        return $this->where('id', $id)->update([
            'password' => $hashedPassword
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
    }

    public function findByUsername(string $username): ?User
    {
        return $this->where('username', $username)->first();
    }

    public function emailExists(string $email): bool
    {
        return $this->where('email', $email)->count() > 0;
    }

    public function usernameExists(string $username): bool
    {
        return $this->where('username', $username)->count() > 0;
    }
}
