<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
    $categoryIcons = ['spices' => '&#127811;', 'tea' => '&#127861;', 'mushroom' => '&#129365;', 'vegetables' => '&#129382;', 'fruits' => '&#127817;', 'other' => '&#128230;'];
    $categoryLabels = ['spices' => 'Spices', 'tea' => 'Tea Leaves', 'mushroom' => 'Mushroom', 'vegetables' => 'Vegetables', 'fruits' => 'Fruits', 'other' => 'Other'];
    $selectedCategory = $_GET['category'] ?? '';
    $selectedLane = $_GET['lane_id'] ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Village Products</h1>
    <?php if (($_SESSION['user_role'] ?? null) === 'student'): ?>
        <a href="<?= url('/products/create') ?>" class="btn btn-primary">+ Add a Villager's Product</a>
    <?php endif; ?>
</div>
<p class="text-muted">Raw produce straight from villagers at wholesale price &mdash; buy low, resell for a profit.</p>

<form method="GET" action="<?= url('/products') ?>" class="row g-2 mb-4">
    <div class="col-auto">
        <select name="category" class="form-select">
            <option value="">All categories</option>
            <?php foreach ($categoryLabels as $value => $label): ?>
                <option value="<?= $value ?>" <?= $selectedCategory === $value ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <select name="lane_id" class="form-select">
            <option value="">All lanes</option>
            <?php foreach ($lanes as $lane): ?>
                <option value="<?= (int) $lane['lane_id'] ?>" <?= (string) $selectedLane === (string) $lane['lane_id'] ? 'selected' : '' ?>><?= htmlspecialchars($lane['lane_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
    </div>
    <?php if ($selectedCategory !== '' || $selectedLane !== ''): ?>
        <div class="col-auto">
            <a href="<?= url('/products') ?>" class="btn btn-outline-secondary">Clear</a>
        </div>
    <?php endif; ?>
</form>

<div class="row g-4">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-secondary mb-2"><?= $categoryIcons[$product['category']] ?? '' ?> <?= htmlspecialchars($categoryLabels[$product['category']] ?? $product['category']) ?></span>
                    <h2 class="h5"><?= htmlspecialchars($product['product_name']) ?></h2>
                    <p class="mb-1">Price: LKR <?= number_format((float) $product['price_per_unit'], 2) ?> / <?= htmlspecialchars($product['unit']) ?></p>
                    <p class="mb-1 text-muted">Available: <?= rtrim(rtrim(number_format((float) $product['quantity_available'], 2), '0'), '.') ?> <?= htmlspecialchars($product['unit']) ?></p>
                    <?php if (!empty($product['lane_name'])): ?>
                        <p class="text-muted mb-1"><?= htmlspecialchars($product['lane_name']) ?></p>
                    <?php endif; ?>
                    <p class="text-muted mb-2">Seller: <?= htmlspecialchars($product['owner_name']) ?></p>
                    <a href="<?= url('/products/' . (int) $product['product_id']) ?>" class="btn btn-sm btn-outline-primary">View &amp; Request</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($products)): ?>
        <p class="text-muted">No products match your filters right now.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
