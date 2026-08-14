<?php

require_once __DIR__ . '/../config/database.php';

class Rider
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(?string $status = 'available', ?string $vehicleType = null, ?string $search = null): array
    {
        $sql = 'SELECT * FROM Riders';
        $conditions = [];
        $params = [];

        if ($status !== null) {
            $conditions[] = 'status = :status';
            $params['status'] = $status;
        }
        if ($vehicleType !== null) {
            $conditions[] = 'vehicle_type = :vehicle_type';
            $params['vehicle_type'] = $vehicleType;
        }
        if ($search !== null && $search !== '') {
            $conditions[] = 'student_name LIKE :search';
            $params['search'] = "%{$search}%";
        }
        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY rider_id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function findByStudent(int $studentId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Riders WHERE student_id = :student_id');
        $stmt->execute(['student_id' => $studentId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Riders WHERE rider_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function upsert(array $data): int
    {
        $existing = $this->findByStudent((int) $data['student_id']);

        if ($existing) {
            $stmt = $this->db->prepare(
                'UPDATE Riders SET student_name = :student_name, student_phone = :student_phone,
                    vehicle_type = :vehicle_type, vehicle_model = :vehicle_model,
                    registration_number = :registration_number, seats_available = :seats_available
                 WHERE student_id = :student_id'
            );
            $stmt->execute($this->bindParams($data));

            return (int) $existing['rider_id'];
        }

        $stmt = $this->db->prepare(
            'INSERT INTO Riders (student_id, student_name, student_phone, vehicle_type, vehicle_model, registration_number, seats_available, status)
             VALUES (:student_id, :student_name, :student_phone, :vehicle_type, :vehicle_model, :registration_number, :seats_available, :status)'
        );
        $stmt->execute($this->bindParams($data) + ['status' => 'available']);

        return (int) $this->db->lastInsertId();
    }

    private function bindParams(array $data): array
    {
        return [
            'student_id'          => $data['student_id'],
            'student_name'        => $data['student_name'],
            'student_phone'       => $data['student_phone'],
            'vehicle_type'        => $data['vehicle_type'],
            'vehicle_model'       => $data['vehicle_model'] ?? null,
            'registration_number' => $data['registration_number'] ?? null,
            'seats_available'     => $data['seats_available'] ?? 1,
        ];
    }

    public function toggleStatus(int $studentId): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE Riders SET status = IF(status = 'available', 'offline', 'available') WHERE student_id = :student_id"
        );

        return $stmt->execute(['student_id' => $studentId]);
    }

    public function delete(int $studentId): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Riders WHERE student_id = :student_id');

        return $stmt->execute(['student_id' => $studentId]);
    }
}
