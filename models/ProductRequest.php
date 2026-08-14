<?php

require_once __DIR__ . '/../config/database.php';

class ProductRequest
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function allByProduct(int $productId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM ProductRequests WHERE product_id = :product_id ORDER BY request_id DESC'
        );
        $stmt->execute(['product_id' => $productId]);

        return $stmt->fetchAll();
    }

    public function allByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            'SELECT pr.*, p.product_name, p.owner_name, p.price_per_unit, p.unit
             FROM ProductRequests pr JOIN Products p ON p.product_id = pr.product_id
             WHERE pr.student_id = :student_id
             ORDER BY pr.request_id DESC'
        );
        $stmt->execute(['student_id' => $studentId]);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ProductRequests WHERE request_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function findExisting(int $productId, int $studentId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM ProductRequests
             WHERE product_id = :product_id AND student_id = :student_id AND status != 'declined'"
        );
        $stmt->execute(['product_id' => $productId, 'student_id' => $studentId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO ProductRequests (product_id, student_id, student_name, student_phone, quantity_requested, message)
             VALUES (:product_id, :student_id, :student_name, :student_phone, :quantity_requested, :message)'
        );
        $stmt->execute([
            'product_id'         => $data['product_id'],
            'student_id'         => $data['student_id'],
            'student_name'       => $data['student_name'],
            'student_phone'      => $data['student_phone'],
            'quantity_requested' => $data['quantity_requested'],
            'message'            => $data['message'] ?? null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function confirm(int $id, float $totalPrice): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE ProductRequests SET status = 'confirmed', total_price = :total_price WHERE request_id = :id"
        );

        return $stmt->execute(['total_price' => $totalPrice, 'id' => $id]);
    }

    public function decline(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE ProductRequests SET status = 'declined' WHERE request_id = :id");

        return $stmt->execute(['id' => $id]);
    }
}
