<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('/css/style.css') ?>">
</head>
<body>

<?php $loggedIn = !empty($_SESSION['user_id']); ?>

<div class="app-shell <?= $loggedIn ? '' : 'app-shell--guest' ?>">

<?php if ($loggedIn): ?>
    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle navigation" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <a class="sidebar-brand" href="<?= url('/dashboard') ?>">
            <span class="sidebar-brand-mark">UC</span>
            <span class="sidebar-brand-name">UniConnect</span>
        </a>

        <nav class="sidebar-nav">
            <a href="<?= url('/dashboard') ?>" class="sidebar-link <?= isActive('/dashboard') ?>">
                <span class="sidebar-icon">&#9635;</span> Dashboard
            </a>
            <a href="<?= url('/boarding') ?>" class="sidebar-link <?= isActive('/boarding') ?>">
                <span class="sidebar-icon">&#8962;</span> Boarding
            </a>
            <a href="<?= url('/jobs') ?>" class="sidebar-link <?= isActive('/jobs') ?>">
                <span class="sidebar-icon">&#128188;</span> Jobs
            </a>
            <a href="<?= url('/rides/request') ?>" class="sidebar-link <?= isActive('/rides') ?>">
                <span class="sidebar-icon">&#128690;</span> Rides
            </a>
            <a href="<?= url('/skills/directory') ?>" class="sidebar-link <?= isActive('/skills') ?>">
                <span class="sidebar-icon">&#9733;</span> Skills
            </a>
            <a href="<?= url('/swaps') ?>" class="sidebar-link <?= isActive('/swaps') ?>">
                <span class="sidebar-icon">&#8646;</span> Swap
            </a>
        </nav>

        <div class="sidebar-profile dropdown">
            <button class="sidebar-profile-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1))) ?></span>
                <span class="sidebar-profile-info">
                    <span class="sidebar-profile-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>
                    <span class="sidebar-profile-role"><?= htmlspecialchars(ucfirst($_SESSION['user_role'] ?? '')) ?></span>
                </span>
                <span class="sidebar-profile-caret">&#9662;</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end sidebar-profile-menu">
                <li>
                    <a class="dropdown-item" href="<?= url('/skills/profile/' . (int) ($_SESSION['user_id'] ?? 0)) ?>">
                        My Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="<?= url('/logout') ?>">Log Out</a>
                </li>
            </ul>
        </div>
    </aside>
<?php else: ?>
    <header class="guest-topbar">
        <a class="guest-brand" href="<?= url('/') ?>">
            <span class="sidebar-brand-mark">UC</span> UniConnect
        </a>
        <nav class="guest-nav">
            <a href="<?= url('/login') ?>">Log In</a>
            <a href="<?= url('/register') ?>" class="btn-pill">Register</a>
        </nav>
    </header>
<?php endif; ?>

<main class="app-main">
    <div class="app-main-inner">
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
