<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('/css/style.css') ?>">
</head>
<body>
<div class="auth-screen">
    <aside class="auth-brand-panel">
        <a class="auth-logo" href="<?= url('/') ?>">
            <span class="sidebar-brand-mark">UC</span> UNICONNECT
        </a>

        <div class="trusted-by">
            <span class="trusted-by-label">Built for &mdash;</span>
            <div class="badge-collage">
                <div class="badge-shard badge-shard--1"></div>
                <div class="badge-shard badge-shard--2"></div>
                <div class="badge-shard badge-shard--3"></div>
                <span class="badge-chip badge-chip--1">Boarding</span>
                <span class="badge-chip badge-chip--2">Jobs &amp; Gigs</span>
                <span class="badge-chip badge-chip--3">Rides</span>
                <span class="badge-chip badge-chip--4">Skill Swap</span>
            </div>
        </div>

        <div class="testimonial-card">
            <p>&ldquo;Found a room 5 minutes from campus and picked up two tutoring gigs in my first week &mdash; all without leaving the app.&rdquo;</p>
            <div class="testimonial-author">
                <span class="avatar">A</span>
                <div>
                    <strong>Amaya Perera</strong>
                    <span>Final Year, Computer Engineering</span>
                </div>
            </div>
            <div class="carousel-dots">
                <span class="active"></span><span></span><span></span>
            </div>
        </div>
    </aside>

    <div class="auth-form-side">