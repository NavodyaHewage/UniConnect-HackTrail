<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">My Help Requests</h1>
    <a href="<?= url('/help-requests/create') ?>" class="btn btn-primary">+ Request a Student</a>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Reward</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $categoryLabels = ['software' => 'Software & Web Dev', 'hardware' => 'Hardware & Repair', 'general' => 'General Errand']; ?>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><a href="<?= url('/help-requests/' . (int) $request['request_id']) ?>"><?= htmlspecialchars($request['title']) ?></a></td>
                    <td><?= htmlspecialchars($categoryLabels[$request['category']] ?? $request['category']) ?></td>
                    <td>LKR <?= number_format((float) $request['reward_amount'], 2) ?></td>
                    <td>
                        <span class="badge bg-<?= $request['status'] === 'completed' ? 'success' : ($request['status'] === 'assigned' ? 'info text-dark' : 'warning text-dark') ?>">
                            <?= htmlspecialchars($request['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($request['status'] === 'assigned'): ?>
                            <form method="POST" action="<?= url('/help-requests/' . (int) $request['request_id'] . '/complete') ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success">Mark Completed</button>
                            </form>
                        <?php elseif ($request['status'] === 'open'): ?>
                            <form method="POST" action="<?= url('/help-requests/' . (int) $request['request_id'] . '/delete') ?>" onsubmit="return confirm('Delete this request?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($requests)): ?>
                <tr><td colspan="5" class="text-muted">You haven't requested a student yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
