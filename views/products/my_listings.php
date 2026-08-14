<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">My Village Products</h1>
<p class="text-muted">Products listed under your name. A student adds new listings on your behalf &mdash; open one below to see who wants to buy and confirm sales.</p>

<?php $categoryLabels = ['spices' => 'Spices', 'tea' => 'Tea Leaves', 'mushroom' => 'Mushroom', 'vegetables' => 'Vegetables', 'fruits' => 'Fruits', 'other' => 'Other']; ?>

<div class="row g-4">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-secondary mb-2"><?= htmlspecialchars($categoryLabels[$product['category']] ?? $product['category']) ?></span>
                    <h2 class="h5"><?= htmlspecialchars($product['product_name']) ?></h2>
                    <p class="mb-1">Price: LKR <?= number_format((float) $product['price_per_unit'], 2) ?> / <?= htmlspecialchars($product['unit']) ?></p>
                    <p class="mb-1">
                        Status:
                        <span class="badge bg-<?= $product['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($product['status']) ?></span>
                    </p>
                    <?php if (!empty($product['lane_name'])): ?>
                        <p class="text-muted mb-2"><?= htmlspecialchars($product['lane_name']) ?></p>
                    <?php endif; ?>
                    <a href="<?= url('/products/' . (int) $product['product_id']) ?>" class="btn btn-sm btn-outline-primary mb-2">View &amp; Manage</a>
                    <form method="POST" action="<?= url('/products/' . (int) $product['product_id'] . '/status') ?>" class="d-flex gap-1">
                        <select name="status" class="form-select form-select-sm w-auto">
                            <option value="available" <?= $product['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="sold_out" <?= $product['status'] === 'sold_out' ? 'selected' : '' ?>>Sold Out</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                    </form>
                    <form method="POST" action="<?= url('/products/' . (int) $product['product_id'] . '/delete') ?>" class="mt-1" onsubmit="return confirm('Delete this product listing?');">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($products)): ?>
        <p class="text-muted">No products have been listed under your name yet.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
