<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($request): ?>
    <?php $categoryLabels = ['software' => 'Software & Web Dev', 'hardware' => 'Hardware & Repair', 'general' => 'General Errand']; ?>
    <span class="badge bg-secondary mb-2"><?= htmlspecialchars($categoryLabels[$request['category']] ?? $request['category']) ?></span>
    <h1 class="h3 mb-3"><?= htmlspecialchars($request['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($request['description'])) ?></p>
    <p><strong>Reward:</strong> LKR <?= number_format((float) $request['reward_amount'], 2) ?></p>
    <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= htmlspecialchars($request['status']) ?></span></p>
    <p><strong>Requested by:</strong> <?= htmlspecialchars($request['villager_name']) ?></p>
    <p><strong>Contact Number:</strong> <?= htmlspecialchars($request['villager_phone']) ?></p>

    <?php if ($request['status'] === 'open' && ($_SESSION['user_role'] ?? null) === 'student'): ?>
        <form method="POST" action="<?= url('/help-requests/' . (int) $request['request_id'] . '/accept') ?>">
            <button type="submit" class="btn btn-primary">Accept This Request</button>
        </form>
    <?php elseif ($request['status'] === 'assigned' && ($_SESSION['user_id'] ?? null) == $request['posted_by']): ?>
        <form method="POST" action="<?= url('/help-requests/' . (int) $request['request_id'] . '/complete') ?>">
            <button type="submit" class="btn btn-success">Mark as Completed</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Help request not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
