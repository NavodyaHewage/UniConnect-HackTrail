<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">My Rider Profile</h1>
<p class="text-muted">Let villagers know when you're available to give a ride on your bike or vehicle.</p>

<?php if ($rider): ?>
    <div class="card mb-4 col-md-6">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1">Current status:
                    <span class="badge bg-<?= $rider['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($rider['status']) ?></span>
                </p>
                <p class="text-muted mb-0">Villagers can only see you in the directory while you're marked available.</p>
            </div>
            <form method="POST" action="<?= url('/riders/toggle') ?>">
                <button type="submit" class="btn btn-sm btn-<?= $rider['status'] === 'available' ? 'outline-secondary' : 'success' ?>">
                    <?= $rider['status'] === 'available' ? 'Go Offline' : 'Go Available' ?>
                </button>
            </form>
        </div>
    </div>
<?php endif; ?>

<form method="POST" action="<?= url('/riders') ?>" class="col-md-6">
    <h2 class="h5"><?= $rider ? 'Update' : 'Create' ?> Rider Details</h2>
    <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" name="student_name" class="form-control" value="<?= htmlspecialchars($rider['student_name'] ?? ($_SESSION['user_name'] ?? '')) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="tel" name="student_phone" class="form-control" value="<?= htmlspecialchars($rider['student_phone'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Vehicle Type</label>
        <select name="vehicle_type" class="form-select">
            <option value="bicycle" <?= ($rider['vehicle_type'] ?? '') === 'bicycle' ? 'selected' : '' ?>>Bicycle</option>
            <option value="motorbike" <?= ($rider['vehicle_type'] ?? '') === 'motorbike' ? 'selected' : '' ?>>Motorbike</option>
            <option value="three_wheeler" <?= ($rider['vehicle_type'] ?? '') === 'three_wheeler' ? 'selected' : '' ?>>Three-Wheeler</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Vehicle Model (optional)</label>
        <input type="text" name="vehicle_model" class="form-control" value="<?= htmlspecialchars($rider['vehicle_model'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Registration Number (optional)</label>
        <input type="text" name="registration_number" class="form-control" value="<?= htmlspecialchars($rider['registration_number'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Seats Available</label>
        <input type="number" min="1" name="seats_available" class="form-control" value="<?= (int) ($rider['seats_available'] ?? 1) ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= $rider ? 'Save Changes' : 'Create Profile' ?></button>
</form>

<?php if ($rider): ?>
    <form method="POST" action="<?= url('/riders/delete') ?>" class="col-md-6 mt-3" onsubmit="return confirm('Remove your rider profile? Villagers will no longer be able to find you.');">
        <button type="submit" class="btn btn-outline-danger btn-sm">Remove Rider Profile</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
