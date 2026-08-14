<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">My Boarding Requests</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Room</th>
                <th>Owner</th>
                <th>Rent</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><a href="<?= url('/boarding/' . (int) $request['boarding_id']) ?>"><?= htmlspecialchars($request['boarding_title']) ?></a></td>
                    <td><?= htmlspecialchars($request['owner_name']) ?></td>
                    <td>LKR <?= number_format((float) $request['rent_amount'], 2) ?></td>
                    <td>
                        <span class="badge bg-<?= $request['status'] === 'confirmed' ? 'success' : ($request['status'] === 'declined' ? 'secondary' : 'warning text-dark') ?>">
                            <?= htmlspecialchars($request['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($request['status'] === 'pending'): ?>
                            <form method="POST" action="<?= url('/boarding/requests/' . (int) $request['request_id'] . '/cancel') ?>" onsubmit="return confirm('Cancel this request?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($requests)): ?>
                <tr><td colspan="5" class="text-muted">You haven't requested any boarding rooms yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
