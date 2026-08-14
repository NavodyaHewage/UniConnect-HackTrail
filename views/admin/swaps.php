<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Skill Swaps</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Offered By</th>
                <th>Requested By</th>
                <th>Service Offered</th>
                <th>Item Exchanged</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($swaps as $swap): ?>
                <tr>
                    <td><?= (int) $swap['swap_id'] ?></td>
                    <td><?= htmlspecialchars($swap['offered_by_name']) ?></td>
                    <td><?= htmlspecialchars($swap['requested_by_name']) ?></td>
                    <td><?= htmlspecialchars($swap['service_offered']) ?></td>
                    <td><?= htmlspecialchars($swap['item_exchanged']) ?></td>
                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($swap['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($swaps)): ?>
                <tr><td colspan="6" class="text-muted">No skill swaps found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
