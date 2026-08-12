<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-visual">
            <div>
                <span class="sidebar-brand-mark">UC</span>
                <h2>Welcome back to UniConnect.</h2>
                <p>Log in to pick up right where you left off &mdash; your rooms, gigs, rides, and swaps are all here.</p>
            </div>
            <ul class="auth-feature-list">
                <li><span class="check">&#10003;</span> Verified boarding &amp; job listings</li>
                <li><span class="check">&#10003;</span> Live ride requests within 3km</li>
                <li><span class="check">&#10003;</span> Your skills profile &amp; badges</li>
            </ul>
        </div>
        <div class="auth-form-panel">
            <a href="<?= url('/') ?>" class="back-to-home">&larr; Back to home</a>
            <h1>Log In</h1>
            <p class="auth-subtitle">Enter your details to access your dashboard.</p>
            <form method="POST" action="<?= url('/login') ?>">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>
            </form>
            <p class="auth-footer-link">No account? <a href="<?= url('/register') ?>">Register here</a></p>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
