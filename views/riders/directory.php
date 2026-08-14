<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
    $vehicleIcons = ['bicycle' => '&#128690;', 'motorbike' => '&#127949;', 'three_wheeler' => '&#128663;'];
    $vehicleLabels = ['bicycle' => 'Bicycle', 'motorbike' => 'Motorbike', 'three_wheeler' => 'Three-Wheeler'];
    $selectedType = $_GET['vehicle_type'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Available Riders</h1>
    <?php if (($_SESSION['user_role'] ?? null) === 'student'): ?>
        <a href="<?= url('/riders/my') ?>" class="btn btn-primary">+ Add / Manage My Ride</a>
    <?php endif; ?>
</div>
<p class="text-muted">Students who currently have a bike or vehicle available &mdash; contact them directly to arrange a ride.</p>

<form method="GET" action="<?= url('/riders') ?>" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="Search by name..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </div>
    <div class="col-auto">
        <select name="vehicle_type" class="form-select">
            <option value="">All vehicle types</option>
            <?php foreach ($vehicleLabels as $value => $label): ?>
                <option value="<?= $value ?>" <?= $selectedType === $value ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
    </div>
    <?php if (($_GET['search'] ?? '') !== '' || $selectedType !== ''): ?>
        <div class="col-auto">
            <a href="<?= url('/riders') ?>" class="btn btn-outline-secondary">Clear</a>
        </div>
    <?php endif; ?>
</form>

<div class="row g-4">
    <?php foreach ($riders as $rider): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-success mb-2">Available</span>
                    <h2 class="h5"><?= $vehicleIcons[$rider['vehicle_type']] ?? '' ?> <?= htmlspecialchars($rider['student_name']) ?></h2>
                    <p class="mb-1"><?= htmlspecialchars($vehicleLabels[$rider['vehicle_type']] ?? $rider['vehicle_type']) ?><?= $rider['vehicle_model'] ? ' &mdash; ' . htmlspecialchars($rider['vehicle_model']) : '' ?></p>
                    <p class="mb-1 text-muted">Seats available: <?= (int) $rider['seats_available'] ?></p>
                    <p class="mb-0"><strong>Contact:</strong> <?= htmlspecialchars($rider['student_phone']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($riders)): ?>
        <p class="text-muted">No riders are available right now. Check back later.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
