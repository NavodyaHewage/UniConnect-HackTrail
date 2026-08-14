<?php

require_once __DIR__ . '/../models/Boarding.php';
require_once __DIR__ . '/../models/Lane.php';
require_once __DIR__ . '/../models/BoardingRequest.php';
require_once __DIR__ . '/../models/User.php';

class BoardingController
{
    private Boarding $boardingModel;
    private Lane $laneModel;
    private BoardingRequest $requestModel;
    private User $userModel;

    public function __construct()
    {
        $this->boardingModel = new Boarding();
        $this->laneModel     = new Lane();
        $this->requestModel  = new BoardingRequest();
        $this->userModel     = new User();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '') ?: null;
        $maxDistance = is_numeric($_GET['max_distance'] ?? null) ? (float) $_GET['max_distance'] : null;

        $listings = $this->boardingModel->all('available', $search, $maxDistance);
        require __DIR__ . '/../views/boarding/listing_grid.php';
    }

    public function show(int $id): void
    {
        $listing = $this->boardingModel->find($id);
        $requests = null;
        $myRequest = null;

        if ($listing && ($_SESSION['user_id'] ?? null) == $listing['owner_id']) {
            $requests = $this->requestModel->allByBoarding($id);
        } elseif ($listing && !empty($_SESSION['user_id'])) {
            $myRequest = $this->requestModel->findExisting($id, (int) $_SESSION['user_id']);
        }

        require __DIR__ . '/../views/boarding/listing_detail.php';
    }

    public function showCreateForm(): void
    {
        $lanes = $this->laneModel->all();
        $villagers = array_filter($this->userModel->all(), fn ($u) => $u['user_role'] === 'villager');
        require __DIR__ . '/../views/boarding/post_room.php';
    }

    public function myListings(): void
    {
        $listings = $this->boardingModel->allByOwner($_SESSION['user_id']);
        foreach ($listings as &$listing) {
            $listing['requests'] = $this->requestModel->allByBoarding((int) $listing['boarding_id']);
        }
        unset($listing);

        require __DIR__ . '/../views/boarding/my_listings.php';
    }

    public function store(): void
    {
        $photoFields = ['boarding_photo', 'boarding_photo_2', 'boarding_photo_3'];
        $photoPaths = [];
        $uploadError = null;

        foreach ($photoFields as $field) {
            [$path, $error] = $this->handlePhotoUpload($field);
            if ($error) {
                $uploadError = $error;
                break;
            }
            $photoPaths[$field] = $path;
        }

        $pdfPath = null;
        if (!$uploadError) {
            [$pdfPath, $uploadError] = $this->handlePdfUpload('boarding_pdf');
        }

        $villager = null;
        if (!$uploadError) {
            $villagerId = (int) ($_POST['villager_id'] ?? 0);
            if ($villagerId > 0) {
                $candidate = $this->userModel->findById($villagerId);
                if ($candidate && $candidate['user_role'] === 'villager') {
                    $villager = $candidate;
                }
            }

            if (!$villager) {
                $uploadError = 'Please select the villager who owns this room.';
            }
        }

        if ($uploadError) {
            // Store error in session and redirect back to form
            $_SESSION['error_message'] = $uploadError;
            // Ideally, you would also repopulate the form with previous input
            // Repopulate the form with previous input
            $_SESSION['old_input'] = $_POST;

            header('Location: ' . url('/boarding/create'));
            exit();
        }

        $laneId = ($_POST['lane_id'] ?? '') !== '' ? (int) $_POST['lane_id'] : null;

        $this->boardingModel->create([
            'owner_id'      => $villager['user_id'],
            'owner_name'    => $villager['name'],
            'owner_phone'   => $villager['phone'],
            'owner_address' => trim($_POST['owner_address'] ?? '') ?: null,
            'title'         => trim($_POST['title'] ?? ''),
            'rent_amount'   => $_POST['rent_amount'] ?? 0,
            'distance_km'   => $_POST['distance_km'] ?? 0,
            'photo_path'    => $photoPaths['boarding_photo'],
            'photo_path_2'  => $photoPaths['boarding_photo_2'],
            'photo_path_3'  => $photoPaths['boarding_photo_3'],
            'pdf_path'      => $pdfPath,
            'lane_id'       => $laneId,
            'ad_fee'        => 500.00,
        ]);

        header('Location: ' . url('/boarding'));
    }

    /**
     * @return array{0: ?string, 1: ?string} [photoPath, errorMessage]
     */
    private function handlePhotoUpload(string $field): array
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }

        if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return [null, 'An error occurred during file upload. Please try again.'];
        }

        $file = $_FILES[$field];
        $fileType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];

        // 1. Validate file size (2MB limit)
        if ($fileSize > 2 * 1024 * 1024) {
            return [null, 'File is too large. Please upload a PNG image under 2MB.'];
        }

        // 2. Validate file type (must be PNG)
        if ($fileType !== 'image/png') {
            return [null, 'Invalid file type. Only PNG images are allowed.'];
        }

        // 3. Define upload directory and create it if it doesn't exist
        $uploadDir = __DIR__ . '/../public/uploads/boarding_photos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // 4. Generate a unique filename to prevent overwrites
        $filename = uniqid('boarding_', true) . '.png';
        $destination = $uploadDir . $filename;

        // 5. Move the uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return [null, 'Failed to move uploaded file.'];
        }

        // 6. Return the relative path for web access
        return ['/uploads/boarding_photos/' . $filename, null];
    }

    /**
     * @return array{0: ?string, 1: ?string} [pdfPath, errorMessage]
     */
    private function handlePdfUpload(string $field): array
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }

        if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return [null, 'An error occurred during PDF upload. Please try again.'];
        }

        $file = $_FILES[$field];
        $fileType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];

        if ($fileSize > 5 * 1024 * 1024) {
            return [null, 'PDF is too large. Please upload a file under 5MB.'];
        }

        if ($fileType !== 'application/pdf') {
            return [null, 'Invalid file type. Only PDF files are allowed.'];
        }

        $uploadDir = __DIR__ . '/../public/uploads/boarding_pdfs/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid('boarding_', true) . '.pdf';
        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return [null, 'Failed to move uploaded PDF.'];
        }

        return ['/uploads/boarding_pdfs/' . $filename, null];
    }

    public function updateStatus(int $id): void
    {
        $status = $_POST['status'] ?? 'available';
        $this->boardingModel->updateStatus($id, $status);
        header('Location: ' . url('/boarding/' . $id));
    }

    public function destroy(int $id): void
    {
        $listing = $this->boardingModel->find($id);
        if ($listing && (int) $listing['owner_id'] === (int) $_SESSION['user_id']) {
            $this->boardingModel->delete($id);
        }

        header('Location: ' . url('/boarding'));
    }

    public function requestBoarding(int $id): void
    {
        $listing = $this->boardingModel->find($id);
        if (!$listing || $listing['status'] !== 'available') {
            header('Location: ' . url('/boarding/' . $id));
            return;
        }

        $existing = $this->requestModel->findExisting($id, (int) $_SESSION['user_id']);
        if (!$existing) {
            $this->requestModel->create([
                'boarding_id'   => $id,
                'student_id'    => $_SESSION['user_id'],
                'student_name'  => trim($_POST['student_name'] ?? ($_SESSION['user_name'] ?? '')),
                'student_phone' => trim($_POST['student_phone'] ?? ''),
                'message'       => trim($_POST['message'] ?? '') ?: null,
            ]);
        }

        header('Location: ' . url('/boarding/' . $id));
    }

    public function confirmRequest(int $requestId): void
    {
        $request = $this->requestModel->find($requestId);
        if ($request) {
            $listing = $this->boardingModel->find((int) $request['boarding_id']);
            if ($listing && (int) $listing['owner_id'] === (int) $_SESSION['user_id']) {
                $tipAmount = (float) ($_POST['tip_amount'] ?? 0);
                $this->requestModel->confirm($requestId, $tipAmount);
                header('Location: ' . url('/boarding/' . (int) $listing['boarding_id']));
                return;
            }
        }

        header('Location: ' . url('/boarding'));
    }

    public function declineRequest(int $requestId): void
    {
        $request = $this->requestModel->find($requestId);
        if ($request) {
            $listing = $this->boardingModel->find((int) $request['boarding_id']);
            if ($listing && (int) $listing['owner_id'] === (int) $_SESSION['user_id']) {
                $this->requestModel->decline($requestId);
                header('Location: ' . url('/boarding/' . (int) $listing['boarding_id']));
                return;
            }
        }

        header('Location: ' . url('/boarding'));
    }

    public function myRequests(): void
    {
        $requests = $this->requestModel->allByStudent($_SESSION['user_id']);
        require __DIR__ . '/../views/boarding/my_requests.php';
    }

    public function cancelRequest(int $requestId): void
    {
        $request = $this->requestModel->find($requestId);
        if ($request && (int) $request['student_id'] === (int) $_SESSION['user_id']) {
            $this->requestModel->delete($requestId);
            $_SESSION['success'] = 'Your request has been cancelled.';
        }

        header('Location: ' . url('/boarding/my-requests'));
    }

    public function agentEarnings(): void
    {
        $earnings = $this->requestModel->earningsByAgent($_SESSION['user_id']);
        $totalEarnings = array_sum(array_column($earnings, 'tip_amount'));
        require __DIR__ . '/../views/boarding/agent_earnings.php';
    }
}
