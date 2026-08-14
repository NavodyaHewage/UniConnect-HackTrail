<?php

require_once __DIR__ . '/../config/database.php';

class ClassEnrollment
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function allByClass(int $classId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM ClassEnrollments WHERE class_id = :class_id ORDER BY enrollment_id DESC');
        $stmt->execute(['class_id' => $classId]);

        return $stmt->fetchAll();
    }

    public function countActiveByClass(int $classId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM ClassEnrollments WHERE class_id = :class_id AND status IN ('pending', 'confirmed')"
        );
        $stmt->execute(['class_id' => $classId]);

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ClassEnrollments WHERE enrollment_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO ClassEnrollments (class_id, student_id, student_name, student_phone, status)
             VALUES (:class_id, :student_id, :student_name, :student_phone, :status)'
        );
        $stmt->execute([
            'class_id'      => $data['class_id'],
            'student_id'    => $data['student_id'],
            'student_name'  => $data['student_name'],
            'student_phone' => $data['student_phone'],
            'status'        => $data['status'] ?? 'pending',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE ClassEnrollments SET status = :status WHERE enrollment_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
