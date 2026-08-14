<?php

require_once __DIR__ . '/../models/HelpRequest.php';

class HelpRequestController
{
    private HelpRequest $requestModel;

    public function __construct()
    {
        $this->requestModel = new HelpRequest();
    }

    public function index(): void
    {
        $category = in_array($_GET['category'] ?? null, ['software', 'hardware', 'general'], true)
            ? $_GET['category']
            : null;

        $requests = $this->requestModel->all('open', $category);
        require __DIR__ . '/../views/help_requests/request_feed.php';
    }

    public function show(int $id): void
    {
        $request = $this->requestModel->find($id);
        require __DIR__ . '/../views/help_requests/request_detail.php';
    }

    public function showCreateForm(): void
    {
        require __DIR__ . '/../views/help_requests/post_request.php';
    }

    public function store(): void
    {
        $category = in_array($_POST['category'] ?? null, ['software', 'hardware', 'general'], true)
            ? $_POST['category']
            : 'general';

        $this->requestModel->create([
            'posted_by'      => $_SESSION['user_id'],
            'villager_name'  => trim($_POST['villager_name'] ?? ($_SESSION['user_name'] ?? '')),
            'villager_phone' => trim($_POST['villager_phone'] ?? ''),
            'title'          => trim($_POST['title'] ?? ''),
            'description'    => trim($_POST['description'] ?? ''),
            'category'       => $category,
            'reward_amount'  => $_POST['reward_amount'] ?? 0,
        ]);

        header('Location: ' . url('/help-requests/my'));
    }

    public function myRequests(): void
    {
        $requests = $this->requestModel->allByVillager($_SESSION['user_id']);
        require __DIR__ . '/../views/help_requests/my_requests.php';
    }

    public function myAccepted(): void
    {
        $requests = $this->requestModel->allByStudent($_SESSION['user_id']);
        require __DIR__ . '/../views/help_requests/my_accepted.php';
    }

    public function accept(int $id): void
    {
        $this->requestModel->accept($id, $_SESSION['user_id']);
        header('Location: ' . url('/help-requests/my-accepted'));
    }

    public function complete(int $id): void
    {
        $request = $this->requestModel->find($id);
        if ($request && (int) $request['posted_by'] === (int) $_SESSION['user_id']) {
            $this->requestModel->complete($id);
        }

        header('Location: ' . url('/help-requests/my'));
    }

    public function destroy(int $id): void
    {
        $request = $this->requestModel->find($id);
        if ($request && (int) $request['posted_by'] === (int) $_SESSION['user_id']) {
            $this->requestModel->delete($id);
        }

        header('Location: ' . url('/help-requests/my'));
    }
}
