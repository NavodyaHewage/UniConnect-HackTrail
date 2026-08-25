<?php

require_once __DIR__ . '/../config/database.php';

class AgentRequest
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = null): array
    {
        $sql = 'SELECT * FROM AgentRequests';
        $params = [];
        if ($status !== null) {
            $sql .= ' WHERE status = :status';
            $params['status'] = $status;
        }
        $sql .= ' ORDER BY request_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM AgentRequests WHERE request_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function findPendingByUser(int $userId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM AgentRequests WHERE user_id = :user_id AND status = 'pending'");
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO AgentRequests (user_id, name, email, contact, service_types)
             VALUES (:user_id, :name, :email, :contact, :service_types)'
        );
        $stmt->execute([
            'user_id'       => $data['user_id'],
            'name'          => $data['name'],
            'email'         => $data['email'],
            'contact'       => $data['contact'],
            'service_types' => $data['service_types'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE AgentRequests SET status = :status WHERE request_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
