<?php require __DIR__ . '/../layout/auth_header.php'; ?>

<div class="auth-topbar">
    Already have an account? <a href="<?= url('/login') ?>">Log in</a>
</div>

<div class="auth-form-scroll">
    <div class="auth-form-col">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="auth-tabs" id="roleTabs">
            <button type="button" class="auth-tab active" data-role="student" data-subtitle="Search rooms, book rides, and apply for gigs near campus.">
                I'm a Student
            </button>
            <button type="button" class="auth-tab" data-role="villager" data-subtitle="List rooms, offer rides, and post local tasks for students.">
                I'm a Villager
            </button>
            <button type="button" class="auth-tab" data-role="admin" data-subtitle="Manage users, listings, and platform-wide moderation.">
                I'm an Admin
            </button>
            <button type="button" class="auth-tab" data-role="agent" data-subtitle="Manage assigned boarding lanes on behalf of the platform.">
                I'm an Agent
            </button>
        </div>

        <h1>Create Your Account</h1>
        <p class="auth-subtitle" id="roleSubtitle">Search rooms, book rides, and apply for gigs near campus.</p>

        <form method="POST" action="<?= url('/register') ?>">
            <input type="hidden" name="user_role" id="userRoleInput" value="student">

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Your full name" required>
                </div>
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
            <button type="submit" class="btn btn-auth-submit w-100">Create Account</button>
        </form>

        <p class="auth-terms">
            By creating your account, you agree to UniConnect's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
        </p>
    </div>
</div>

<?php require __DIR__ . '/../layout/auth_footer.php'; ?>
