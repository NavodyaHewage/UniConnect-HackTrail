<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Request a Student</h1>
<p class="text-muted">Post a task you need a student's help with &mdash; any available student can accept it.</p>

<form method="POST" action="<?= url('/help-requests') ?>" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" name="villager_name" class="form-control" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Your Phone Number</label>
        <input type="tel" name="villager_phone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Fix my TV remote" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-select">
            <option value="general">General Errand</option>
            <option value="software">Software &amp; Web Dev</option>
            <option value="hardware">Hardware &amp; Repair</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Reward (LKR)</label>
        <input type="number" step="0.01" name="reward_amount" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Post Request</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
