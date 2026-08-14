<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
    $categoryLabels = ['software' => 'Software & Web Dev', 'hardware' => 'Hardware & Repair'];
    $heading = $categoryLabels[$category] ?? null;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><?= $heading ? htmlspecialchars($heading) . ' Jobs' : 'Job Marketplace' ?></h1>
    <?php if (($_SESSION['user_role'] ?? null) === 'student'): ?>
        <a href="<?= url('/jobs/create') ?>" class="btn btn-primary">+ Post a Task</a>
    <?php endif; ?>
</div>

<div class="row g-4">
    <?php foreach ($jobs as $job): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-secondary mb-2"><?= htmlspecialchars($categoryLabels[$job['category']] ?? $job['category']) ?></span>
                    <h2 class="h5"><?= htmlspecialchars($job['title']) ?></h2>
                    <p class="text-muted"><?= htmlspecialchars(mb_strimwidth($job['description'], 0, 100, '...')) ?></p>
                    <p class="mb-1">Budget: LKR <?= number_format((float) $job['budget'], 2) ?></p>
                    <a href="<?= url('/jobs/' . (int) $job['job_id']) ?>" class="btn btn-sm btn-outline-primary">View &amp; Apply</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($jobs)): ?>
        <p class="text-muted">No open jobs right now.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
