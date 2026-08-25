<?php

require_once __DIR__ . '/../models/AgentRequest.php';

class AgentRequestController
{
    public const SERVICE_TYPES = ['rider', 'electrician', 'plumber', 'carpenter', 'tutor', 'delivery', 'other'];

    private AgentRequest $agentRequestModel;

    public function __construct()
    {
        $this->agentRequestModel = new AgentRequest();
    }

    public function showCreateForm(): void
    {
        $pendingRequest = $this->agentRequestModel->findPendingByUser($_SESSION['user_id']);
        require __DIR__ . '/../views/agent_requests/apply.php';
    }

    public function store(): void
    {
        if ($this->agentRequestModel->findPendingByUser($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You already have a pending agent request.';
            header('Location: ' . url('/agent-requests/create'));
            return;
        }

        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $contact = trim($_POST['contact'] ?? '');
        $types   = array_intersect($_POST['service_types'] ?? [], self::SERVICE_TYPES);

        if ($name === '' || $email === '' || $contact === '' || empty($types)) {
            $_SESSION['error'] = 'Please fill in all fields and select at least one service type.';
            header('Location: ' . url('/agent-requests/create'));
            return;
        }

        $this->agentRequestModel->create([
            'user_id'       => $_SESSION['user_id'],
            'name'          => $name,
            'email'         => $email,
            'contact'       => $contact,
            'service_types' => implode(',', $types),
        ]);

        $_SESSION['success'] = 'Your agent request has been submitted for admin review.';
        header('Location: ' . url('/agent-requests/create'));
    }
}
