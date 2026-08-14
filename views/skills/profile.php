<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($profileUser): ?>
    <?php $isOwnProfile = ($_SESSION['user_id'] ?? null) == $profileUser['user_id']; ?>
    <div class="d-flex align-items-center gap-2 mb-4">
        <h1 class="h3 mb-0"><?= htmlspecialchars($isOwnProfile ? 'My Skill Profile' : $profileUser['name'] . "'s Skill Profile") ?></h1>
        <span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($profileUser['user_role'])) ?></span>
    </div>

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
                            <p class="text-muted small mt-2 mb-2"><?= htmlspecialchars($skill['verification_source']) ?></p>
                        <?php endif; ?>
                        <?php if ($isOwnProfile): ?>
                            <form method="POST" action="<?= url('/skills/' . (int) $skill['skill_id'] . '/delete') ?>" class="mt-2" onsubmit="return confirm('Remove this skill?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($skills)): ?>
            <p class="text-muted"><?= $isOwnProfile ? 'No skills added yet.' : 'This user has not added any skills yet.' ?></p>
        <?php endif; ?>
    </div>

    <?php if ($isOwnProfile): ?>
        <form method="POST" action="<?= url('/skills') ?>" class="col-md-6">
            <h2 class="h5">Add a Skill</h2>
            <div class="mb-3">
                <label class="form-label">Skill Name</label>
                <input type="text" name="skill_name" class="form-control" placeholder="e.g. Organic Farming, Web Development" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Verification Source (e.g. course code, years of experience)</label>
                <input type="text" name="verification_source" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Skill</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">User not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
