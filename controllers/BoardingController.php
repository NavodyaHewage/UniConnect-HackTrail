<?php

require_once __DIR__ . '/../models/Boarding.php';
require_once __DIR__ . '/../models/BoardingInterest.php';

class BoardingController
{
    private Boarding $boardingModel;
    private BoardingInterest $interestModel;

    public function __construct()
    {
        $this->boardingModel = new Boarding();
        $this->interestModel = new BoardingInterest();
    }

    public function index(): void
    {
        $listings = $this->boardingModel->all('available');
        require __DIR__ . '/../views/boarding/listing_grid.php';
    }

    public function show(int $id): void
    {
        $listing = $this->boardingModel->find($id);
        $interestedStudents = [];
        $hasExpressedInterest = false;
        $userId = $_SESSION['user_id'] ?? null;

        if ($listing && $userId) {
            if ((int) $listing['owner_id'] === (int) $userId) {
                $interestedStudents = $this->interestModel->allForBoarding($id);
            } else {
                $hasExpressedInterest = $this->interestModel->hasExpressed($id, (int) $userId);
            }
        }

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

    public function expressInterest(int $id): void
    {
        $listing = $this->boardingModel->find($id);

        if ($listing && (int) $listing['owner_id'] !== (int) $_SESSION['user_id']) {
            $this->interestModel->express($id, (int) $_SESSION['user_id']);
        }

        header('Location: ' . url('/boarding/' . $id));
    }
}
