<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">My Lane Agent Earnings</h1>

<p class="text-muted">If you're assigned as the agent for a lane, you earn a tip from the villager every time a boarding request in your lane is confirmed.</p>

<p class="mb-4">Total confirmed tips: <strong>LKR <?= number_format($totalEarnings, 2) ?></strong></p>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Lane</th>
                <th>Room</th>
                <th>Villager</th>
                <th>Tip</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($earnings as $earning): ?>
                <tr>
                    <td><?= htmlspecialchars($earning['lane_name']) ?></td>
                    <td><a href="<?= url('/boarding/' . (int) $earning['boarding_id']) ?>"><?= htmlspecialchars($earning['boarding_title']) ?></a></td>
                    <td><?= htmlspecialchars($earning['owner_name']) ?></td>
                    <td>LKR <?= number_format((float) $earning['tip_amount'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($earnings)): ?>
                <tr><td colspan="4" class="text-muted">No confirmed tips yet. You'll see earnings here once a booking in your lane is confirmed.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
