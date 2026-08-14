<?php

require_once __DIR__ . '/../config/database.php';

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'available', ?string $category = null, ?int $laneId = null): array
    {
        $sql = 'SELECT p.*, l.lane_name FROM Products p LEFT JOIN Lanes l ON l.lane_id = p.lane_id';
        $conditions = [];
        $params = [];

        if ($status !== null) {
            $conditions[] = 'p.status = :status';
            $params['status'] = $status;
        }
        if ($category !== null) {
            $conditions[] = 'p.category = :category';
            $params['category'] = $category;
        }
        if ($laneId !== null) {
            $conditions[] = 'p.lane_id = :lane_id';
            $params['lane_id'] = $laneId;
        }
        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY p.product_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, l.lane_name FROM Products p LEFT JOIN Lanes l ON l.lane_id = p.lane_id WHERE p.product_id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function allByOwner(int $ownerId): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, l.lane_name FROM Products p LEFT JOIN Lanes l ON l.lane_id = p.lane_id
             WHERE p.owner_id = :owner_id ORDER BY p.product_id DESC'
        );
        $stmt->execute(['owner_id' => $ownerId]);

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Products (owner_id, owner_name, owner_phone, product_name, category, description, price_per_unit, unit, quantity_available, lane_id)
             VALUES (:owner_id, :owner_name, :owner_phone, :product_name, :category, :description, :price_per_unit, :unit, :quantity_available, :lane_id)'
        );
        $stmt->execute([
            'owner_id'           => $data['owner_id'],
            'owner_name'         => $data['owner_name'],
            'owner_phone'        => $data['owner_phone'],
            'product_name'       => $data['product_name'],
            'category'           => $data['category'] ?? 'other',
            'description'        => $data['description'] ?? null,
            'price_per_unit'     => $data['price_per_unit'],
            'unit'               => $data['unit'] ?? 'kg',
            'quantity_available' => $data['quantity_available'] ?? 0,
            'lane_id'            => $data['lane_id'] ?? null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Products SET status = :status WHERE product_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Products WHERE product_id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
