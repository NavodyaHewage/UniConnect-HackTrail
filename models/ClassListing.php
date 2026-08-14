<?php

require_once __DIR__ . '/../config/database.php';

class ClassListing
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'open'): array
    {
        $sql = 'SELECT * FROM Classes';
        $params = [];
        if ($status !== null) {
            $sql .= ' WHERE status = :status';
            $params['status'] = $status;
        }
        $sql .= ' ORDER BY class_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Classes WHERE class_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function allByTutor(int $tutorId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM Classes WHERE tutor_id = :tutor_id ORDER BY class_id DESC');
        $stmt->execute(['tutor_id' => $tutorId]);

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Classes (tutor_id, tutor_name, tutor_phone, subject, title, description, class_type, price, max_students, schedule, status)
             VALUES (:tutor_id, :tutor_name, :tutor_phone, :subject, :title, :description, :class_type, :price, :max_students, :schedule, :status)'
        );
        $stmt->execute([
            'tutor_id'     => $data['tutor_id'],
            'tutor_name'   => $data['tutor_name'],
            'tutor_phone'  => $data['tutor_phone'],
            'subject'      => $data['subject'],
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'class_type'   => $data['class_type'],
            'price'        => $data['price'],
            'max_students' => $data['max_students'],
            'schedule'     => $data['schedule'] ?? null,
            'status'       => $data['status'] ?? 'open',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE Classes SET status = :status WHERE class_id = :id');

        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Classes WHERE class_id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
