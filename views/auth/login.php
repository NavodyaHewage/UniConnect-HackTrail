<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <h1 class="h3 mb-4">Log In</h1>
        <form method="POST" action="<?= url('/login') ?>">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Log In</button>
        </form>
        <p class="mt-3">No account? <a href="<?= url('/register') ?>">Register here</a></p>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
