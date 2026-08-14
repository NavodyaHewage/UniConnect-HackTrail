<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Post a Local Task</h1>

<form method="POST" action="<?= url('/jobs') ?>" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" name="poster_name" class="form-control" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Telephone Number</label>
        <input type="tel" name="poster_phone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Budget (LKR)</label>
        <input type="number" step="0.01" name="budget" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-select">
            <option value="software">Software &amp; Web Dev</option>
            <option value="hardware">Hardware &amp; Repair</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Post Task</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
