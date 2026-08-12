<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Job Marketplace</h1>
    <a href="/jobs/create" class="btn btn-primary">+ Post a Task</a>
</div>

<ul class="nav nav-tabs mb-4">
    <li class="nav-item"><a class="nav-link <?= !$category ? 'active' : '' ?>" href="/jobs">All</a></li>
    <li class="nav-item"><a class="nav-link <?= $category === 'software' ? 'active' : '' ?>" href="/jobs?category=software">Software &amp; Web Dev</a></li>
    <li class="nav-item"><a class="nav-link <?= $category === 'hardware' ? 'active' : '' ?>" href="/jobs?category=hardware">Hardware &amp; Repair</a></li>
    <li class="nav-item"><a class="nav-link <?= $category === 'tutoring' ? 'active' : '' ?>" href="/jobs?category=tutoring">Tutoring &amp; Coaching</a></li>
</ul>

<div class="row g-4">
    <?php foreach ($jobs as $job): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5"><?= htmlspecialchars($job['title']) ?></h2>
                    <p class="text-muted"><?= htmlspecialchars(mb_strimwidth($job['description'], 0, 100, '...')) ?></p>
                    <p class="mb-1">Budget: LKR <?= number_format((float) $job['budget'], 2) ?></p>
                    <a href="/jobs/<?= (int) $job['job_id'] ?>" class="btn btn-sm btn-outline-primary">View &amp; Apply</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($jobs)): ?>
        <p class="text-muted">No open jobs right now.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
