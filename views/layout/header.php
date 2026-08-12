<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('/css/style.css') ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= url('/') ?>">UniConnect</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= url('/boarding') ?>">Boarding</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('/jobs') ?>">Jobs</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('/rides/request') ?>">Rides</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('/skills/directory') ?>">Skills</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('/swaps') ?>">Swap</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/logout') ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
