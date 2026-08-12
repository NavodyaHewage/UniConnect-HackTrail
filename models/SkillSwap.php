<?php

require_once __DIR__ . '/../config/database.php';

class SkillSwap
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = null): array
    {
        $sql = 'SELECT sw.*, o.name AS offered_by_name, r.name AS requested_by_name
                FROM SkillSwaps sw
                JOIN Users o ON o.user_id = sw.offered_by
                JOIN Users r ON r.user_id = sw.requested_by';
        $params = [];
        if ($status !== null) {
            $sql .= ' WHERE sw.status = :status';
            $params['status'] = $status;
        }
        $sql .= ' ORDER BY sw.created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM SkillSwaps WHERE swap_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function propose(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO SkillSwaps (offered_by, requested_by, service_offered, item_exchanged)
             VALUES (:offered_by, :requested_by, :service_offered, :item_exchanged)'
        );
        $stmt->execute([
            'offered_by'      => $data['offered_by'],
            'requested_by'    => $data['requested_by'],
            'service_offered' => $data['service_offered'],
            'item_exchanged'  => $data['item_exchanged'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE SkillSwaps SET status = :status WHERE swap_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
