<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Time-Bank / Skill Swap Feed</h1>
    <a href="/swaps/propose" class="btn btn-primary">+ Propose a Swap</a>
</div>

<table class="table">
    <thead>
        <tr><th>Offered By</th><th>Requested By</th><th>Service Offered</th><th>Item Exchanged</th><th>Status</th></tr>
    </thead>
    <tbody>
        <?php foreach ($swaps as $swap): ?>
            <tr>
                <td><?= htmlspecialchars($swap['offered_by_name']) ?></td>
                <td><?= htmlspecialchars($swap['requested_by_name']) ?></td>
                <td><?= htmlspecialchars($swap['service_offered']) ?></td>
                <td><?= htmlspecialchars($swap['item_exchanged']) ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($swap['status']) ?></span></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($swaps)): ?>
            <tr><td colspan="5" class="text-muted">No swaps proposed yet.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>
