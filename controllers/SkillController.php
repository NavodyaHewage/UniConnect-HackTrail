<?php

require_once __DIR__ . '/../models/Skill.php';

class SkillController
{
    private Skill $skillModel;

    public function __construct()
    {
        $this->skillModel = new Skill();
    }

    public function profile(int $userId): void
    {
        $skills = $this->skillModel->allByUser($userId);
        require __DIR__ . '/../views/skills/profile.php';
    }

    public function directory(): void
    {
        $term    = trim($_GET['q'] ?? '');
        $results = $term !== '' ? $this->skillModel->search($term) : [];
        require __DIR__ . '/../views/skills/directory.php';
    }

    public function store(): void
    {
        $this->skillModel->create([
            'user_id'             => $_SESSION['user_id'],
            'skill_name'          => trim($_POST['skill_name'] ?? ''),
            'verification_source' => trim($_POST['verification_source'] ?? ''),
        ]);

        header('Location: ' . url('/skills/profile/' . $_SESSION['user_id']));
    }

    public function verify(int $id): void
    {
        // Admin-only action, gated by user_role in the front controller.
        $this->skillModel->verify($id);
        header('Location: ' . url('/skills/directory'));
    }
}
