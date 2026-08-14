<?php

require_once __DIR__ . '/../config/database.php';

class Boarding
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'available', ?string $search = null, ?float $maxDistance = null): array
    {
        $sql = 'SELECT * FROM Boardings';
        $conditions = [];
        $params = [];
        if ($status !== null) {
            $conditions[] = 'status = :status';
            $params['status'] = $status;
        }
        if ($search !== null && $search !== '') {
            $conditions[] = 'title LIKE :search';
            $params['search'] = "%{$search}%";
        }
        if ($maxDistance !== null) {
            $conditions[] = 'distance_km <= :max_distance';
            $params['max_distance'] = $maxDistance;
        }
        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY boarding_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT b.*, l.lane_name
             FROM Boardings b LEFT JOIN Lanes l ON l.lane_id = b.lane_id
             WHERE b.boarding_id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function allByOwner(int $ownerId): array
    {
        $stmt = $this->db->prepare(
            'SELECT b.*, l.lane_name
             FROM Boardings b LEFT JOIN Lanes l ON l.lane_id = b.lane_id
             WHERE b.owner_id = :owner_id
             ORDER BY b.boarding_id DESC'
        );
        $stmt->execute(['owner_id' => $ownerId]);

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Boardings (owner_id, owner_name, owner_phone, owner_address, title, rent_amount, distance_km, status, photo_path, photo_path_2, photo_path_3, pdf_path, lane_id, ad_fee)
             VALUES (:owner_id, :owner_name, :owner_phone, :owner_address, :title, :rent_amount, :distance_km, :status, :photo_path, :photo_path_2, :photo_path_3, :pdf_path, :lane_id, :ad_fee)'
        );
        $stmt->execute([
            'owner_id'      => $data['owner_id'],
            'owner_name'    => $data['owner_name'],
            'owner_phone'   => $data['owner_phone'],
            'owner_address' => $data['owner_address'] ?? null,
            'title'         => $data['title'],
            'rent_amount'   => $data['rent_amount'],
            'distance_km'   => $data['distance_km'],
            'status'        => $data['status'] ?? 'available',
            'photo_path'    => $data['photo_path'] ?? null,
            'photo_path_2'  => $data['photo_path_2'] ?? null,
            'photo_path_3'  => $data['photo_path_3'] ?? null,
            'pdf_path'      => $data['pdf_path'] ?? null,
            'lane_id'       => $data['lane_id'] ?? null,
            'ad_fee'        => $data['ad_fee'] ?? 500.00,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function totalAdRevenue(): float
    {
        return (float) $this->db->query('SELECT COALESCE(SUM(ad_fee), 0) FROM Boardings')->fetchColumn();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Boardings SET status = :status WHERE boarding_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Boardings WHERE boarding_id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
