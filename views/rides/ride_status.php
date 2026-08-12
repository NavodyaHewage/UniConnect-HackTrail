<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($ride): ?>
    <h1 class="h3 mb-3">Ride #<?= (int) $ride['ride_id'] ?></h1>
    <p><strong>From:</strong> <?= htmlspecialchars($ride['pickup_location']) ?></p>
    <p><strong>To:</strong> <?= htmlspecialchars($ride['drop_location']) ?></p>
    <p><strong>Fare:</strong> LKR <?= number_format((float) $ride['fare_amount'], 2) ?></p>
    <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= htmlspecialchars($ride['ride_status']) ?></span></p>

    <form method="POST" action="<?= url('/rides/status/' . (int) $ride['ride_id']) ?>">
        <select name="status" class="form-select w-auto d-inline-block">
            <?php foreach (['requested', 'accepted', 'in_progress', 'completed', 'cancelled'] as $option): ?>
                <option value="<?= $option ?>" <?= $ride['ride_status'] === $option ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $option)) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
    </form>
<?php else: ?>
    <p class="text-muted">Ride not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
