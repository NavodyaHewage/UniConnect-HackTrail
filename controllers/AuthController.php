<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLogin(): void
    {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister(): void
    {
        require __DIR__ . '/../views/auth/register.php';
    }

    public function register(): void
    {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = $_POST['user_role'] ?? '';

        if ($name === '' || $email === '' || $phone === '' || $password === '' || !in_array($role, ['student', 'villager'], true)) {
            $_SESSION['error'] = 'All fields are required.';
            header('Location: ' . url('/register'));
            return;
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = 'An account with that email already exists.';
            header('Location: ' . url('/register'));
            return;
        }

        $userId = $this->userModel->create($name, $email, $phone, $password, $role);
        $_SESSION['user_id']   = $userId;
        $_SESSION['user_role'] = $role;

        header('Location: ' . url('/dashboard'));
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Invalid email or password.';
            header('Location: ' . url('/login'));
            return;
        }

        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_role'] = $user['user_role'];

        header('Location: ' . url('/dashboard'));
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ' . url('/login'));
    }
}
