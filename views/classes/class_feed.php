<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Classes by University Students</h1>
    <?php if (($_SESSION['user_role'] ?? null) === 'student'): ?>
        <a href="<?= url('/skills/classes/create') ?>" class="btn btn-primary">+ Post a Class</a>
    <?php endif; ?>
</div>

<div class="row g-4">
    <?php foreach ($classes as $class): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-<?= $class['class_type'] === 'group' ? 'info text-dark' : 'secondary' ?> mb-2">
                        <?= $class['class_type'] === 'group' ? 'Group Class' : 'Individual Class' ?>
                    </span>
                    <h2 class="h5"><?= htmlspecialchars($class['title']) ?></h2>
                    <p class="mb-1"><strong>Subject:</strong> <?= htmlspecialchars($class['subject']) ?></p>
                    <p class="mb-1">Price: LKR <?= number_format((float) $class['price'], 2) ?></p>
                    <p class="text-muted mb-1">Taught by <?= htmlspecialchars($class['tutor_name']) ?></p>
                    <a href="<?= url('/skills/classes/' . (int) $class['class_id']) ?>" class="btn btn-sm btn-outline-primary">View &amp; Enroll</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($classes)): ?>
        <p class="text-muted">No classes available right now.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
