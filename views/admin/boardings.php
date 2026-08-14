<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Manage Boarding Listings</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Owner</th>
                <th>Rent</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($boardings as $listing): ?>
                <tr>
                    <td><?= (int) $listing['boarding_id'] ?></td>
                    <td><?= htmlspecialchars($listing['title']) ?></td>
                    <td><?= htmlspecialchars($listing['owner_name']) ?> (<?= htmlspecialchars($listing['owner_phone']) ?>)</td>
                    <td>LKR <?= number_format((float) $listing['rent_amount'], 2) ?></td>
                    <td><span class="badge bg-<?= $listing['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($listing['status']) ?></span></td>
                    <td>
                        <form method="POST" action="<?= url('/admin/boardings/' . (int) $listing['boarding_id'] . '/delete') ?>" onsubmit="return confirm('Delete this listing?');">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($boardings)): ?>
                <tr><td colspan="6" class="text-muted">No boarding listings found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
