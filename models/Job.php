<?php

require_once __DIR__ . '/../config/database.php';

class Job
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'open'): array
    {
        $sql = 'SELECT j.*, u.name AS posted_by_name
                FROM Jobs j JOIN Users u ON u.user_id = j.posted_by';
        $params = [];
        if ($status !== null) {
            $sql .= ' WHERE j.status = :status';
            $params['status'] = $status;
        }
        $sql .= ' ORDER BY j.job_id DESC';

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
            'INSERT INTO Jobs (posted_by, title, description, budget, status, latitude, longitude)
             VALUES (:posted_by, :title, :description, :budget, :status, :latitude, :longitude)'
        );
        $stmt->execute([
            'posted_by'   => $data['posted_by'],
            'title'       => $data['title'],
            'description' => $data['description'],
            'budget'      => $data['budget'],
            'status'      => $data['status'] ?? 'open',
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Jobs SET status = :status WHERE job_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
