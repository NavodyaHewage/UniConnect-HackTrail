<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Skills Directory</h1>

<form method="GET" action="<?= url('/skills/directory') ?>" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="q" class="form-control" placeholder="Search skills (e.g. PCB Repair)" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">Search</button>
    </div>
</form>

<div class="row g-3">
    <?php foreach ($results as $result): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 mb-1"><?= htmlspecialchars($result['skill_name']) ?></h2>
                    <p class="mb-1"><?= htmlspecialchars($result['user_name']) ?></p>
                    <?php if ($result['is_verified']): ?>
                        <span class="badge bg-success">Verified Badge</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($results)): ?>
        <p class="text-muted">Search for a skill to see matching students and community members.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
