<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Skill Profile</h1>

<div class="row g-3 mb-4">
    <?php foreach ($skills as $skill): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 mb-1"><?= htmlspecialchars($skill['skill_name']) ?></h2>
                    <?php if ($skill['is_verified']): ?>
                        <span class="badge bg-success">Verified Badge</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Unverified</span>
                    <?php endif; ?>
                    <?php if (!empty($skill['verification_source'])): ?>
                        <p class="text-muted small mt-2"><?= htmlspecialchars($skill['verification_source']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($skills)): ?>
        <p class="text-muted">No skills added yet.</p>
    <?php endif; ?>
</div>

<form method="POST" action="/skills" class="col-md-6">
    <h2 class="h5">Add a Skill</h2>
    <div class="mb-3">
        <label class="form-label">Skill Name</label>
        <input type="text" name="skill_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Verification Source (e.g. course code)</label>
        <input type="text" name="verification_source" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Add Skill</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
