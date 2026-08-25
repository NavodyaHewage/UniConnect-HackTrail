<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Boarding.php';
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../models/Skill.php';
require_once __DIR__ . '/../models/SkillSwap.php';
require_once __DIR__ . '/../models/Lane.php';
require_once __DIR__ . '/../models/AgentRequest.php';

class AdminController
{
    private User $userModel;
    private Boarding $boardingModel;
    private Job $jobModel;
    private Skill $skillModel;
    private SkillSwap $swapModel;
    private Lane $laneModel;
    private AgentRequest $agentRequestModel;

    public function __construct()
    {
        $this->userModel         = new User();
        $this->boardingModel     = new Boarding();
        $this->jobModel          = new Job();
        $this->skillModel        = new Skill();
        $this->swapModel         = new SkillSwap();
        $this->laneModel         = new Lane();
        $this->agentRequestModel = new AgentRequest();
    }

    public function dashboard(): void
    {
        $stats = [
            'users'                  => count($this->userModel->all()),
            'boardings'              => count($this->boardingModel->all(null)),
            'jobs'                   => count($this->jobModel->all(null)),
            'swaps'                  => count($this->swapModel->all()),
            'ad_revenue'             => $this->boardingModel->totalAdRevenue(),
            'pending_agent_requests' => count($this->agentRequestModel->all('pending')),
        ];
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function users(): void
    {
        $users = $this->userModel->all();
        require __DIR__ . '/../views/admin/users.php';
    }

    public function updateUserRole(int $id): void
    {
        $role = $_POST['user_role'] ?? '';

        if ($id === (int) $_SESSION['user_id']) {
            $_SESSION['error'] = "You can't change your own role.";
            header('Location: ' . url('/admin/users'));
            return;
        }

        if (!in_array($role, ['student', 'villager', 'admin', 'agent'], true)) {
            $_SESSION['error'] = 'Invalid role.';
            header('Location: ' . url('/admin/users'));
            return;
        }

        $this->userModel->updateRole($id, $role);
        header('Location: ' . url('/admin/users'));
    }

    public function deleteUser(int $id): void
    {
        if ($id === (int) $_SESSION['user_id']) {
            $_SESSION['error'] = "You can't delete your own account.";
            header('Location: ' . url('/admin/users'));
            return;
        }

        try {
            $this->userModel->delete($id);
        } catch (PDOException $e) {
            $_SESSION['error'] = 'This user has existing listings, gigs, or other records and cannot be deleted until those are removed first.';
        }

        header('Location: ' . url('/admin/users'));
    }

    public function showCreateAdminForm(): void
    {
        require __DIR__ . '/../views/admin/create_admin.php';
    }

    public function createAdmin(): void
    {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || $phone === '' || $password === '') {
            $_SESSION['error'] = 'All fields are required.';
            header('Location: ' . url('/admin/create-admin'));
            return;
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = 'An account with that email already exists.';
            header('Location: ' . url('/admin/create-admin'));
            return;
        }

        $this->userModel->create($name, $email, $phone, $password, 'admin');
        header('Location: ' . url('/admin/users'));
    }

    public function boardings(): void
    {
        $boardings = $this->boardingModel->all(null);
        require __DIR__ . '/../views/admin/boardings.php';
    }

    public function deleteBoarding(int $id): void
    {
        $this->boardingModel->delete($id);
        header('Location: ' . url('/admin/boardings'));
    }

    public function jobs(): void
    {
        $jobs = $this->jobModel->all(null);
        require __DIR__ . '/../views/admin/jobs.php';
    }

    public function deleteJob(int $id): void
    {
        $this->jobModel->delete($id);
        header('Location: ' . url('/admin/jobs'));
    }

    public function skills(): void
    {
        $skills = $this->skillModel->all();
        require __DIR__ . '/../views/admin/skills.php';
    }

    public function verifySkill(int $id): void
    {
        $this->skillModel->verify($id);
        header('Location: ' . url('/admin/skills'));
    }

    public function swaps(): void
    {
        $swaps = $this->swapModel->all();
        require __DIR__ . '/../views/admin/swaps.php';
    }

    public function lanes(): void
    {
        $lanes = $this->laneModel->all();
        $students = array_filter($this->userModel->all(), fn ($u) => $u['user_role'] === 'student');
        require __DIR__ . '/../views/admin/lanes.php';
    }

    public function createLane(): void
    {
        $laneName = trim($_POST['lane_name'] ?? '');
        $agentId = (int) ($_POST['agent_id'] ?? 0);

        if ($laneName !== '' && $agentId > 0) {
            $this->laneModel->create($laneName, $agentId);
        }

        header('Location: ' . url('/admin/lanes'));
    }

    public function agentRequests(): void
    {
        $agentRequests = $this->agentRequestModel->all();
        require __DIR__ . '/../views/admin/agent_requests.php';
    }

    public function approveAgentRequest(int $id): void
    {
        $request = $this->agentRequestModel->find($id);
        if ($request) {
            $this->agentRequestModel->updateStatus($id, 'approved');
            $this->userModel->updateRole((int) $request['user_id'], 'agent');
        }

        header('Location: ' . url('/admin/agent-requests'));
    }

    public function rejectAgentRequest(int $id): void
    {
        $this->agentRequestModel->updateStatus($id, 'rejected');
        header('Location: ' . url('/admin/agent-requests'));
    }
}
