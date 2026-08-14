<?php

require_once __DIR__ . '/../config/database.php';

class BoardingRequest
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function allByBoarding(int $boardingId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM BoardingRequests WHERE boarding_id = :boarding_id ORDER BY request_id DESC'
        );
        $stmt->execute(['boarding_id' => $boardingId]);

        return $stmt->fetchAll();
    }

    public function allByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            'SELECT br.*, b.title AS boarding_title, b.owner_name, b.rent_amount
             FROM BoardingRequests br JOIN Boardings b ON b.boarding_id = br.boarding_id
             WHERE br.student_id = :student_id
             ORDER BY br.request_id DESC'
        );
        $stmt->execute(['student_id' => $studentId]);

        return $stmt->fetchAll();
    }

    public function findExisting(int $boardingId, int $studentId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM BoardingRequests
             WHERE boarding_id = :boarding_id AND student_id = :student_id AND status != 'declined'"
        );
        $stmt->execute(['boarding_id' => $boardingId, 'student_id' => $studentId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM BoardingRequests WHERE request_id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO BoardingRequests (boarding_id, student_id, student_name, student_phone, message)
             VALUES (:boarding_id, :student_id, :student_name, :student_phone, :message)'
        );
        $stmt->execute([
            'boarding_id'   => $data['boarding_id'],
            'student_id'    => $data['student_id'],
            'student_name'  => $data['student_name'],
            'student_phone' => $data['student_phone'],
            'message'       => $data['message'] ?? null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function confirm(int $id, float $tipAmount): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE BoardingRequests SET status = 'confirmed', tip_amount = :tip_amount WHERE request_id = :id"
        );

        return $stmt->execute(['tip_amount' => $tipAmount, 'id' => $id]);
    }

    public function decline(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE BoardingRequests SET status = 'declined' WHERE request_id = :id");

        return $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM BoardingRequests WHERE request_id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function earningsByAgent(int $agentId): array
    {
        $stmt = $this->db->prepare(
            "SELECT br.*, b.title AS boarding_title, b.owner_name, l.lane_name
             FROM BoardingRequests br
             JOIN Boardings b ON b.boarding_id = br.boarding_id
             JOIN Lanes l ON l.lane_id = b.lane_id
             WHERE l.agent_id = :agent_id AND br.status = 'confirmed'
             ORDER BY br.request_id DESC"
        );
        $stmt->execute(['agent_id' => $agentId]);

        return $stmt->fetchAll();
    }
}
