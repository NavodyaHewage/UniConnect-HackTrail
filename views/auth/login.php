<?php require __DIR__ . '/../layout/auth_header.php'; ?>

<div class="auth-topbar">
    New here? <a href="<?= url('/register') ?>">Register</a>
</div>

<div class="auth-form-scroll">
    <div class="auth-form-col">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <h1>Log In to UniConnect</h1>
        <p class="auth-subtitle">Pick up right where you left off &mdash; your rooms, gigs, rides, and swaps.</p>

        <form method="POST" action="<?= url('/login') ?>">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required>
            </div>
            <button type="submit" class="btn btn-auth-submit w-100">Log In</button>
        </form>

        <p class="auth-terms">
            By continuing, you agree to UniConnect's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
        </p>
    </div>
</div>

<?php require __DIR__ . '/../layout/auth_footer.php'; ?>
