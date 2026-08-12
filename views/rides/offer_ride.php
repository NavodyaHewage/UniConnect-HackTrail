<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Offer a Ride</h1>

<table class="table">
    <thead>
        <tr><th>Vehicle</th><th>Type</th><th>Status</th><th>Action</th></tr>
    </thead>
    <tbody>
        <?php foreach ($vehicles as $vehicle): ?>
            <tr>
                <td><?= htmlspecialchars($vehicle['model_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($vehicle['vehicle_type']) ?></td>
                <td><span class="badge bg-<?= $vehicle['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($vehicle['status']) ?></span></td>
                <td>
                    <form method="POST" action="<?= url('/rides/offer/toggle') ?>" class="d-inline">
                        <input type="hidden" name="vehicle_id" value="<?= (int) $vehicle['vehicle_id'] ?>">
                        <select name="status" class="form-select form-select-sm d-inline w-auto">
                            <option value="available" <?= $vehicle['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="busy" <?= $vehicle['status'] === 'busy' ? 'selected' : '' ?>>Busy</option>
                            <option value="offline" <?= $vehicle['status'] === 'offline' ? 'selected' : '' ?>>Offline</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($vehicles)): ?>
            <tr><td colspan="4" class="text-muted">No vehicles registered yet.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>
