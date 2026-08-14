<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">My Accepted Requests</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Villager</th>
                <th>Reward</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><a href="<?= url('/help-requests/' . (int) $request['request_id']) ?>"><?= htmlspecialchars($request['title']) ?></a></td>
                    <td><?= htmlspecialchars($request['villager_name']) ?></td>
                    <td>LKR <?= number_format((float) $request['reward_amount'], 2) ?></td>
                    <td>
                        <span class="badge bg-<?= $request['status'] === 'completed' ? 'success' : 'info text-dark' ?>">
                            <?= htmlspecialchars($request['status']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($requests)): ?>
                <tr><td colspan="4" class="text-muted">You haven't accepted any help requests yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
