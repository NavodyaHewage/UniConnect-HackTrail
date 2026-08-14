<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Manage Skills</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Skill</th>
                <th>Verification Source</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($skills as $skill): ?>
                <tr>
                    <td><?= (int) $skill['skill_id'] ?></td>
                    <td><?= htmlspecialchars($skill['user_name']) ?></td>
                    <td><?= htmlspecialchars($skill['skill_name']) ?></td>
                    <td><?= htmlspecialchars($skill['verification_source'] ?? '') ?></td>
                    <td><span class="badge bg-<?= $skill['is_verified'] ? 'success' : 'secondary' ?>"><?= $skill['is_verified'] ? 'Verified' : 'Unverified' ?></span></td>
                    <td>
                        <?php if (!$skill['is_verified']): ?>
                            <form method="POST" action="<?= url('/admin/skills/' . (int) $skill['skill_id'] . '/verify') ?>">
                                <button type="submit" class="btn btn-sm btn-primary">Verify</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($skills)): ?>
                <tr><td colspan="6" class="text-muted">No skills found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
