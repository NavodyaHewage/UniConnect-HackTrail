<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Swap History</h1>

<table class="table">
    <thead>
        <tr><th>Offered By</th><th>Requested By</th><th>Service</th><th>Item</th><th>Status</th><th>Date</th></tr>
    </thead>
    <tbody>
        <?php foreach ($swaps as $swap): ?>
            <tr>
                <td><?= htmlspecialchars($swap['offered_by_name']) ?></td>
                <td><?= htmlspecialchars($swap['requested_by_name']) ?></td>
                <td><?= htmlspecialchars($swap['service_offered']) ?></td>
                <td><?= htmlspecialchars($swap['item_exchanged']) ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($swap['status']) ?></span></td>
                <td><?= htmlspecialchars($swap['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($swaps)): ?>
            <tr><td colspan="6" class="text-muted">No swap history yet.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>
