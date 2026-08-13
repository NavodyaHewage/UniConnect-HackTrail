<?php

require_once __DIR__ . '/../config/database.php';

class Ride
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = null): array
    {
        $sql = 'SELECT r.*, v.vehicle_type, v.model_name, d.name AS driver_name
                FROM Rides r
                JOIN Vehicles v ON v.vehicle_id = r.vehicle_id
                JOIN Users d ON d.user_id = r.driver_id';
        $params = [];
        if ($status !== null) {
            $sql .= ' WHERE r.ride_status = :status';
            $params['status'] = $status;
        }
        $sql .= ' ORDER BY r.created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Rides WHERE ride_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Rides SET ride_status = :status WHERE ride_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
