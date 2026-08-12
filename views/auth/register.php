<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="h3 mb-4">Create an Account</h1>
        <form method="POST" action="<?= url('/register') ?>">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">I am a...</label>
                <select name="user_role" class="form-select" required>
                    <option value="student">Student</option>
                    <option value="villager">Villager (Landlord / Community Member)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="mt-3">Already have an account? <a href="<?= url('/login') ?>">Log in</a></p>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
