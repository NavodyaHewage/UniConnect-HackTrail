<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Add a Villager's Product</h1>
<p class="text-muted">Villagers can't list products themselves &mdash; as a student, you're adding this listing on behalf of the villager who has the produce.</p>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error_message']) ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<form method="POST" action="<?= url('/products') ?>" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Villager (Seller)</label>
        <select name="villager_id" class="form-select" required>
            <option value="">Select the villager who owns this product</option>
            <?php foreach ($villagers as $villager): ?>
                <option value="<?= (int) $villager['user_id'] ?>"><?= htmlspecialchars($villager['name']) ?> (<?= htmlspecialchars($villager['phone']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="product_name" class="form-control" placeholder="e.g. Ceylon Cinnamon, Green Tea Leaves" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-select">
            <option value="spices">Spices</option>
            <option value="tea">Tea Leaves</option>
            <option value="mushroom">Mushroom</option>
            <option value="vegetables">Vegetables</option>
            <option value="fruits">Fruits</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Description (optional)</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Price per Unit (LKR)</label>
            <input type="number" step="0.01" name="price_per_unit" class="form-control" required>
        </div>
        <div class="col mb-3">
            <label class="form-label">Unit</label>
            <input type="text" name="unit" class="form-control" placeholder="kg" value="kg">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Quantity Available</label>
        <input type="number" step="0.01" min="0" name="quantity_available" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Lane</label>
        <select name="lane_id" class="form-select">
            <option value="">Not on a covered lane</option>
            <?php foreach ($lanes as $lane): ?>
                <option value="<?= (int) $lane['lane_id'] ?>"><?= htmlspecialchars($lane['lane_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Publish Product</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
