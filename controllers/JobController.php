<?php

require_once __DIR__ . '/../models/Job.php';

class JobController
{
    private Job $jobModel;

    public function __construct()
    {
        $this->jobModel = new Job();
    }

    public function index(): void
    {
        $category = $_GET['category'] ?? null;
        $jobs = $this->jobModel->all('open');
        require __DIR__ . '/../views/jobs/job_feed.php';
    }

    public function show(int $id): void
    {
        $job = $this->jobModel->find($id);
        require __DIR__ . '/../views/jobs/job_detail.php';
    }

    public function showCreateForm(): void
    {
        require __DIR__ . '/../views/jobs/post_job.php';
    }

    public function store(): void
    {
        $this->jobModel->create([
            'posted_by'   => $_SESSION['user_id'],
            'title'       => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'budget'      => $_POST['budget'] ?? 0,
            'latitude'    => $_POST['latitude'] ?? null,
            'longitude'   => $_POST['longitude'] ?? null,
        ]);

        header('Location: /jobs');
    }

    public function myApplications(): void
    {
        require __DIR__ . '/../views/jobs/my_applications.php';
    }

    public function updateStatus(int $id): void
    {
        $status = $_POST['status'] ?? 'open';
        $this->jobModel->updateStatus($id, $status);
        header('Location: /jobs/' . $id);
    }
}
