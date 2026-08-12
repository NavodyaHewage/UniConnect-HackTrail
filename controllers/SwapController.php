<?php

require_once __DIR__ . '/../models/SkillSwap.php';

class SwapController
{
    private SkillSwap $swapModel;

    public function __construct()
    {
        $this->swapModel = new SkillSwap();
    }

    public function index(): void
    {
        $swaps = $this->swapModel->all();
        require __DIR__ . '/../views/swaps/barter_feed.php';
    }

    public function showProposeForm(): void
    {
        require __DIR__ . '/../views/swaps/propose_swap.php';
    }

    public function propose(): void
    {
        $this->swapModel->propose([
            'offered_by'      => $_SESSION['user_id'],
            'requested_by'    => $_POST['requested_by'],
            'service_offered' => trim($_POST['service_offered'] ?? ''),
            'item_exchanged'  => trim($_POST['item_exchanged'] ?? ''),
        ]);

        header('Location: /swaps');
    }

    public function history(): void
    {
        $swaps = $this->swapModel->all();
        require __DIR__ . '/../views/swaps/swap_history.php';
    }

    public function updateStatus(int $id): void
    {
        $status = $_POST['status'] ?? 'proposed';
        $this->swapModel->updateStatus($id, $status);
        header('Location: /swaps');
    }
}
