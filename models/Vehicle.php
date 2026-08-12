<?php

require_once __DIR__ . '/../config/database.php';

class Vehicle
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function allByOwner(int $ownerId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM Vehicles WHERE owner_id = :owner_id');
        $stmt->execute(['owner_id' => $ownerId]);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Vehicles WHERE vehicle_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Vehicles (owner_id, vehicle_type, registration_number, model_name, seats_available, status)
             VALUES (:owner_id, :vehicle_type, :registration_number, :model_name, :seats_available, :status)'
        );
        $stmt->execute([
            'owner_id'            => $data['owner_id'],
            'vehicle_type'        => $data['vehicle_type'],
            'registration_number' => $data['registration_number'] ?? 'N/A',
            'model_name'          => $data['model_name'] ?? null,
            'seats_available'     => $data['seats_available'] ?? 1,
            'status'              => $data['status'] ?? 'available',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Vehicles SET status = :status WHERE vehicle_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
