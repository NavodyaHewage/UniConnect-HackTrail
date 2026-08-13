<?php

require_once __DIR__ . '/../config/database.php';

class BoardingInterest
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function express(int $boardingId, int $studentId): void
    {
        $stmt = $this->db->prepare(
            'INSERT IGNORE INTO BoardingInterests (boarding_id, student_id) VALUES (:boarding_id, :student_id)'
        );
        $stmt->execute([
            'boarding_id' => $boardingId,
            'student_id'  => $studentId,
        ]);
    }

    public function hasExpressed(int $boardingId, int $studentId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT 1 FROM BoardingInterests WHERE boarding_id = :boarding_id AND student_id = :student_id'
        );
        $stmt->execute([
            'boarding_id' => $boardingId,
            'student_id'  => $studentId,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public function allForBoarding(int $boardingId): array
    {
        $stmt = $this->db->prepare(
            'SELECT bi.*, u.name, u.phone, u.email
             FROM BoardingInterests bi
             JOIN Users u ON u.user_id = bi.student_id
             WHERE bi.boarding_id = :boarding_id
             ORDER BY bi.created_at DESC'
        );
        $stmt->execute(['boarding_id' => $boardingId]);

        return $stmt->fetchAll();
    }
}
