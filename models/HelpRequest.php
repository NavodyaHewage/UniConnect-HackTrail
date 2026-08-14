<?php

require_once __DIR__ . '/../config/database.php';

class HelpRequest
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'open', ?string $category = null): array
    {
        $sql = 'SELECT * FROM HelpRequests';
        $conditions = [];
        $params = [];

        if ($status !== null) {
            $conditions[] = 'status = :status';
            $params['status'] = $status;
        }
        if ($category !== null) {
            $conditions[] = 'category = :category';
            $params['category'] = $category;
        }
        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY request_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM HelpRequests WHERE request_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function allByVillager(int $villagerId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM HelpRequests WHERE posted_by = :posted_by ORDER BY request_id DESC');
        $stmt->execute(['posted_by' => $villagerId]);

        return $stmt->fetchAll();
    }

    public function allByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM HelpRequests WHERE assigned_student_id = :student_id ORDER BY request_id DESC');
        $stmt->execute(['student_id' => $studentId]);

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO HelpRequests (posted_by, villager_name, villager_phone, title, description, category, reward_amount)
             VALUES (:posted_by, :villager_name, :villager_phone, :title, :description, :category, :reward_amount)'
        );
        $stmt->execute([
            'posted_by'      => $data['posted_by'],
            'villager_name'  => $data['villager_name'],
            'villager_phone' => $data['villager_phone'],
            'title'          => $data['title'],
            'description'    => $data['description'],
            'category'       => $data['category'] ?? 'general',
            'reward_amount'  => $data['reward_amount'] ?? 0,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function accept(int $id, int $studentId): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE HelpRequests SET status = 'assigned', assigned_student_id = :student_id
             WHERE request_id = :id AND status = 'open'"
        );

        return $stmt->execute(['student_id' => $studentId, 'id' => $id]);
    }

    public function complete(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE HelpRequests SET status = 'completed' WHERE request_id = :id");

        return $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM HelpRequests WHERE request_id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
