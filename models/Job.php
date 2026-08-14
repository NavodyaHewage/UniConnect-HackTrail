<?php

require_once __DIR__ . '/../config/database.php';

class Job
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'open', ?string $category = null): array
    {
        $sql = 'SELECT * FROM Jobs';
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
        $sql .= ' ORDER BY job_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Jobs WHERE job_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Jobs (posted_by, poster_name, poster_phone, title, description, budget, status, category)
             VALUES (:posted_by, :poster_name, :poster_phone, :title, :description, :budget, :status, :category)'
        );
        $stmt->execute([
            'posted_by'    => $data['posted_by'],
            'poster_name'  => $data['poster_name'],
            'poster_phone' => $data['poster_phone'],
            'title'        => $data['title'],
            'description'  => $data['description'],
            'budget'       => $data['budget'],
            'status'       => $data['status'] ?? 'open',
            'category'     => $data['category'] ?? 'software',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Jobs SET status = :status WHERE job_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function incrementViews(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE Jobs SET views = views + 1 WHERE job_id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Jobs WHERE job_id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
