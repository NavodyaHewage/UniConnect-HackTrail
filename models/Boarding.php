<?php

require_once __DIR__ . '/../config/database.php';

class Boarding
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'available'): array
    {
        $sql = 'SELECT b.*, u.name AS owner_name, u.phone AS owner_phone
                FROM Boardings b JOIN Users u ON u.user_id = b.owner_id';
        $params = [];
        if ($status !== null) {
            $sql .= ' WHERE b.status = :status';
            $params['status'] = $status;
        }
        $sql .= ' ORDER BY b.boarding_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Boardings WHERE boarding_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Boardings (owner_id, title, rent_amount, distance_km, status, latitude, longitude)
             VALUES (:owner_id, :title, :rent_amount, :distance_km, :status, :latitude, :longitude)'
        );
        $stmt->execute([
            'owner_id'    => $data['owner_id'],
            'title'       => $data['title'],
            'rent_amount' => $data['rent_amount'],
            'distance_km' => $data['distance_km'],
            'status'      => $data['status'] ?? 'available',
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Boardings SET status = :status WHERE boarding_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
