<?php

require_once __DIR__ . '/../models/Rider.php';

class RiderController
{
    private Rider $riderModel;

    public function __construct()
    {
        $this->riderModel = new Rider();
    }

    public function index(): void
    {
        $vehicleType = in_array($_GET['vehicle_type'] ?? null, ['bicycle', 'motorbike', 'three_wheeler'], true)
            ? $_GET['vehicle_type']
            : null;
        $search = trim($_GET['search'] ?? '') ?: null;

        $riders = $this->riderModel->all('available', $vehicleType, $search);
        require __DIR__ . '/../views/riders/directory.php';
    }

    public function myRider(): void
    {
        $rider = $this->riderModel->findByStudent($_SESSION['user_id']);
        require __DIR__ . '/../views/riders/my_rider.php';
    }

    public function store(): void
    {
        $vehicleType = in_array($_POST['vehicle_type'] ?? null, ['bicycle', 'motorbike', 'three_wheeler'], true)
            ? $_POST['vehicle_type']
            : 'bicycle';

        $isUpdate = $this->riderModel->findByStudent($_SESSION['user_id']) !== null;

        $this->riderModel->upsert([
            'student_id'          => $_SESSION['user_id'],
            'student_name'        => trim($_POST['student_name'] ?? ($_SESSION['user_name'] ?? '')),
            'student_phone'       => trim($_POST['student_phone'] ?? ''),
            'vehicle_type'        => $vehicleType,
            'vehicle_model'       => trim($_POST['vehicle_model'] ?? '') ?: null,
            'registration_number' => trim($_POST['registration_number'] ?? '') ?: null,
            'seats_available'     => max(1, (int) ($_POST['seats_available'] ?? 1)),
        ]);

        $_SESSION['success'] = $isUpdate ? 'Rider details saved.' : 'Rider profile created.';
        header('Location: ' . url('/riders/my'));
    }

    public function toggleStatus(): void
    {
        $this->riderModel->toggleStatus($_SESSION['user_id']);
        $rider = $this->riderModel->findByStudent($_SESSION['user_id']);
        $_SESSION['success'] = $rider && $rider['status'] === 'available'
            ? 'You are now marked available.'
            : 'You are now marked offline.';
        header('Location: ' . url('/riders/my'));
    }

    public function destroy(): void
    {
        $this->riderModel->delete($_SESSION['user_id']);
        $_SESSION['success'] = 'Rider profile removed.';
        header('Location: ' . url('/riders/my'));
    }
}
