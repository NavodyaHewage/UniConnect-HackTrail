<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Post a Local Task</h1>

<form method="POST" action="<?= url('/jobs') ?>" class="col-md-6">
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
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Latitude</label>
            <input type="text" name="latitude" class="form-control">
        </div>
        <div class="col mb-3">
            <label class="form-label">Longitude</label>
            <input type="text" name="longitude" class="form-control">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Post Task</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
