<?php

require_once __DIR__ . '/../config/database.php';

class Skill
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM Skills WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->db->query(
            'SELECT s.*, u.name AS user_name, u.user_role
             FROM Skills s JOIN Users u ON u.user_id = s.user_id
             ORDER BY s.is_verified ASC, s.skill_id DESC'
        );

        return $stmt->fetchAll();
    }

    public function search(string $term): array
    {
        $stmt = $this->db->prepare(
            'SELECT s.*, u.name AS user_name, u.user_role
             FROM Skills s JOIN Users u ON u.user_id = s.user_id
             WHERE s.skill_name LIKE :term
             ORDER BY s.is_verified DESC, s.skill_id DESC'
        );
        $stmt->execute(['term' => "%{$term}%"]);

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Skills (user_id, skill_name, verification_source, is_verified)
             VALUES (:user_id, :skill_name, :verification_source, :is_verified)'
        );
        $stmt->execute([
            'user_id'             => $data['user_id'],
            'skill_name'          => $data['skill_name'],
            'verification_source' => $data['verification_source'] ?? null,
            'is_verified'         => $data['is_verified'] ?? false,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function verify(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE Skills SET is_verified = TRUE WHERE skill_id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Skills WHERE skill_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Skills WHERE skill_id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
