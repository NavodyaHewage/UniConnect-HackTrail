<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="hero">
    <span class="hero-eyebrow">&#128205; Built for Faculty of Technology students</span>
    <h1>Your campus, connected within 3km.</h1>
    <p class="lead">
        UniConnect brings boarding, rides, gigs, skills, and cashless barter into one
        hyper-local platform &mdash; verified, geo-fenced, and built by students for the community around campus.
    </p>
    <div class="hero-actions">
        <a href="<?= url('/register') ?>" class="btn-pill">Get Started Free</a>
        <a href="<?= url('/login') ?>" class="btn-pill btn-pill--ghost">Log In</a>
    </div>
</section>

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-value">&lt; 3km</div>
        <div class="stat-label">Geo-fenced campus radius</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">5</div>
        <div class="stat-label">Core modules in one app</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">0 LKR</div>
        <div class="stat-label">Cashless skill-swap option</div>
    </div>
</div>

<div class="section-heading">
    <h2>Everything you need, hyper-local</h2>
    <p>One platform for students and the surrounding community &mdash; no more scattered chat groups and unverified listings.</p>
</div>

<div class="feature-grid">
    <div class="feature-card">
        <span class="feature-icon">&#8962;</span>
        <h3>Smart Accommodation</h3>
        <p>Search, filter, and book verified boarding rooms and annexes with transparent pricing and direct owner contact.</p>
    </div>
    <div class="feature-card">
        <span class="feature-icon">&#128188;</span>
        <h3>Micro-Job Marketplace</h3>
        <p>Apply for or post IT repair, software help, tutoring, and hardware gigs tailored to student schedules.</p>
    </div>
    <div class="feature-card">
        <span class="feature-icon">&#128690;</span>
        <h3>Ride System</h3>
        <p>Offer or request bicycle rides and tuk-tuks nearby, with live status tracking and fair fares.</p>
    </div>
    <div class="feature-card">
        <span class="feature-icon">&#9733;</span>
        <h3>Skills Directory &amp; Badges</h3>
        <p>Public talent profiles with automated course-linked verification badges that build instant trust.</p>
    </div>
    <div class="feature-card">
        <span class="feature-icon">&#8646;</span>
        <h3>Time-Bank / Skill Swap</h3>
        <p>Trade tech help for home-cooked meals, produce, or transport &mdash; a cashless barter economy.</p>
    </div>
    <div class="feature-card">
        <span class="feature-icon">&#128737;</span>
        <h3>Geo-Fenced Security</h3>
        <p>Every listing and task is restricted to a strict 2&ndash;3km radius for safety, convenience, and trust.</p>
    </div>
</div>

<div class="cta-banner">
    <h2>Ready to join your campus network?</h2>
    <p>Create a free account as a Student or Villager and start connecting in minutes.</p>
    <a href="<?= url('/register') ?>" class="btn-pill">Create Your Account</a>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
