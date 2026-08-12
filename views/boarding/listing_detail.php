<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($listing): ?>
    <h1 class="h3 mb-3"><?= htmlspecialchars($listing['title']) ?></h1>
    <p><strong>Rent:</strong> LKR <?= number_format((float) $listing['rent_amount'], 2) ?></p>
    <p><strong>Distance from campus:</strong> <?= htmlspecialchars($listing['distance_km']) ?> km</p>
    <p><strong>Status:</strong> <span class="badge bg-<?= $listing['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($listing['status']) ?></span></p>

    <?php if (($_SESSION['user_id'] ?? null) == $listing['owner_id']): ?>
        <form method="POST" action="<?= url('/boarding/' . (int) $listing['boarding_id'] . '/status') ?>">
            <select name="status" class="form-select w-auto d-inline-block">
                <option value="available" <?= $listing['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                <option value="occupied" <?= $listing['status'] === 'occupied' ? 'selected' : '' ?>>Occupied</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Listing not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
