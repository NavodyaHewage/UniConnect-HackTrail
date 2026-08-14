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
        if (!in_array($category, ['software', 'hardware'], true)) {
            $category = null;
        }
        $jobs = $this->jobModel->all('open', $category);
        require __DIR__ . '/../views/jobs/job_feed.php';
    }

    public function show(int $id): void
    {
        $this->jobModel->incrementViews($id);
        $job = $this->jobModel->find($id);
        require __DIR__ . '/../views/jobs/job_detail.php';
    }

    public function showCreateForm(): void
    {
        require __DIR__ . '/../views/jobs/post_job.php';
    }

    public function store(): void
    {
        $category = in_array($_POST['category'] ?? null, ['software', 'hardware'], true)
            ? $_POST['category']
            : 'software';

        $this->jobModel->create([
            'posted_by'    => $_SESSION['user_id'],
            'poster_name'  => trim($_POST['poster_name'] ?? ''),
            'poster_phone' => trim($_POST['poster_phone'] ?? ''),
            'title'        => trim($_POST['title'] ?? ''),
            'description'  => trim($_POST['description'] ?? ''),
            'budget'       => $_POST['budget'] ?? 0,
            'category'     => $category,
        ]);

        header('Location: ' . url('/jobs'));
    }

    public function myApplications(): void
    {
        require __DIR__ . '/../views/jobs/my_applications.php';
    }

    public function updateStatus(int $id): void
    {
        $status = $_POST['status'] ?? 'open';
        $this->jobModel->updateStatus($id, $status);
        header('Location: ' . url('/jobs/' . $id));
    }
}
