<?php

require_once __DIR__ . '/../config/database.php';

class Lane
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query(
            'SELECT l.*, u.name AS agent_name
             FROM Lanes l JOIN Users u ON u.user_id = l.agent_id
             ORDER BY l.lane_name'
        );

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Lanes WHERE lane_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(string $laneName, int $agentId): int
    {
        $stmt = $this->db->prepare('INSERT INTO Lanes (lane_name, agent_id) VALUES (:lane_name, :agent_id)');
        $stmt->execute(['lane_name' => $laneName, 'agent_id' => $agentId]);

        return (int) $this->db->lastInsertId();
    }
}
