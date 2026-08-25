<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Users</h1>
    <a href="<?= url('/admin/create-admin') ?>" class="btn btn-primary">+ Create Admin</a>
</div>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Joined</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= (int) $user['user_id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><span class="badge bg-<?= $user['user_role'] === 'admin' ? 'danger' : 'secondary' ?>"><?= htmlspecialchars($user['user_role']) ?></span></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td>
                        <?php if ((int) $user['user_id'] === (int) $_SESSION['user_id']): ?>
                            <span class="text-muted">You</span>
                        <?php else: ?>
                            <div class="d-flex gap-2">
                                <form method="POST" action="<?= url('/admin/users/' . (int) $user['user_id'] . '/role') ?>" class="d-flex gap-1">
                                    <select name="user_role" class="form-select form-select-sm">
                                        <?php foreach (['student', 'villager', 'admin', 'agent'] as $role): ?>
                                            <option value="<?= $role ?>" <?= $user['user_role'] === $role ? 'selected' : '' ?>><?= ucfirst($role) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                                <form method="POST" action="<?= url('/admin/users/' . (int) $user['user_id'] . '/delete') ?>" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($users)): ?>
                <tr><td colspan="7" class="text-muted">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
