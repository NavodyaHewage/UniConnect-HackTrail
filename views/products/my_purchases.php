<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">My Product Purchases</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Product</th>
                <th>Seller</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?= htmlspecialchars($request['product_name']) ?></td>
                    <td><?= htmlspecialchars($request['owner_name']) ?></td>
                    <td><?= rtrim(rtrim(number_format((float) $request['quantity_requested'], 2), '0'), '.') ?> <?= htmlspecialchars($request['unit']) ?></td>
                    <td><?= $request['total_price'] !== null ? 'LKR ' . number_format((float) $request['total_price'], 2) : '&mdash;' ?></td>
                    <td>
                        <span class="badge bg-<?= $request['status'] === 'confirmed' ? 'success' : ($request['status'] === 'declined' ? 'secondary' : 'warning text-dark') ?>">
                            <?= htmlspecialchars($request['status']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($requests)): ?>
                <tr><td colspan="5" class="text-muted">You haven't requested to buy any products yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
