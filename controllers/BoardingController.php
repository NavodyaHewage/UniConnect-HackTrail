<?php

require_once __DIR__ . '/../models/Boarding.php';

class BoardingController
{
    private Boarding $boardingModel;

    public function __construct()
    {
        $this->boardingModel = new Boarding();
    }

    public function index(): void
    {
        $listings = $this->boardingModel->all('available');
        require __DIR__ . '/../views/boarding/listing_grid.php';
    }

    public function show(int $id): void
    {
        $listing = $this->boardingModel->find($id);
        require __DIR__ . '/../views/boarding/listing_detail.php';
    }

    public function showCreateForm(): void
    {
        require __DIR__ . '/../views/boarding/post_room.php';
    }

    public function store(): void
    {
        $this->boardingModel->create([
            'owner_id'    => $_SESSION['user_id'],
            'title'       => trim($_POST['title'] ?? ''),
            'rent_amount' => $_POST['rent_amount'] ?? 0,
            'distance_km' => $_POST['distance_km'] ?? 0,
            'latitude'    => $_POST['latitude'] ?? null,
            'longitude'   => $_POST['longitude'] ?? null,
        ]);

        header('Location: ' . url('/boarding'));
    }

    public function updateStatus(int $id): void
    {
        $status = $_POST['status'] ?? 'available';
        $this->boardingModel->updateStatus($id, $status);
        header('Location: ' . url('/boarding/' . $id));
    }
}
