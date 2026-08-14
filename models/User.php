<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(string $name, string $email, string $phone, string $password, string $role): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Users (name, email, phone, password, user_role)
             VALUES (:name, :email, :phone, :password, :role)'
        );
        $stmt->execute([
            'name'     => $name,
            'email'    => $email,
            'phone'    => $phone,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $role,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Users WHERE user_id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT user_id, name, email, phone, user_role, created_at FROM Users ORDER BY user_id DESC');

        return $stmt->fetchAll();
    }
}
