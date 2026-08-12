<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-visual">
            <div>
                <span class="sidebar-brand-mark">UC</span>
                <h2>Join your campus network.</h2>
                <p>One account for boarding, rides, gigs, skills, and cashless barter &mdash; all within 3km of campus.</p>
            </div>
            <ul class="auth-feature-list">
                <li><span class="check">&#10003;</span> Free for students &amp; the local community</li>
                <li><span class="check">&#10003;</span> Build a verified skills profile</li>
                <li><span class="check">&#10003;</span> Geo-fenced for safety &amp; trust</li>
            </ul>
        </div>
        <div class="auth-form-panel">
            <a href="<?= url('/') ?>" class="back-to-home">&larr; Back to home</a>
            <h1>Create an Account</h1>
            <p class="auth-subtitle">Tell us a bit about you to get started.</p>
            <form method="POST" action="<?= url('/register') ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Your full name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="07X XXX XXXX" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">I am a...</label>
                    <select name="user_role" class="form-select" required>
                        <option value="student">Student</option>
                        <option value="villager">Villager (Landlord / Community Member)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Create Account</button>
            </form>
            <p class="auth-footer-link">Already have an account? <a href="<?= url('/login') ?>">Log in</a></p>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
