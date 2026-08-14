<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">My Classes</h1>
    <a href="<?= url('/skills/classes/create') ?>" class="btn btn-primary">+ Post a Class</a>
</div>

<?php $totalEarnings = array_sum(array_column($classes, 'earnings')); ?>
<p class="text-muted">Total confirmed earnings: <strong>LKR <?= number_format($totalEarnings, 2) ?></strong></p>

<?php foreach ($classes as $class): ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <h2 class="h5 mb-1"><?= htmlspecialchars($class['title']) ?></h2>
                    <p class="mb-1 text-muted"><?= htmlspecialchars($class['subject']) ?> &middot; <?= $class['class_type'] === 'group' ? 'Group' : 'Individual' ?> &middot; LKR <?= number_format((float) $class['price'], 2) ?>/student</p>
                    <p class="mb-1">Earnings so far: <strong>LKR <?= number_format($class['earnings'], 2) ?></strong></p>
                </div>
                <div class="d-flex gap-2">
                    <form method="POST" action="<?= url('/skills/classes/' . (int) $class['class_id'] . '/status') ?>">
                        <select name="status" class="form-select form-select-sm d-inline-block w-auto">
                            <option value="open" <?= $class['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                            <option value="closed" <?= $class['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                    </form>
                    <form method="POST" action="<?= url('/skills/classes/' . (int) $class['class_id'] . '/delete') ?>" onsubmit="return confirm('Delete this class? This cannot be undone.');">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-sm table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($class['enrollments'] as $enrollment): ?>
                            <tr>
                                <td><?= htmlspecialchars($enrollment['student_name']) ?></td>
                                <td><?= htmlspecialchars($enrollment['student_phone']) ?></td>
                                <td><?= htmlspecialchars($enrollment['status']) ?></td>
                                <td>
                                    <form method="POST" action="<?= url('/skills/classes/enrollments/' . (int) $enrollment['enrollment_id'] . '/status') ?>" class="d-flex gap-1">
                                        <select name="status" class="form-select form-select-sm w-auto">
                                            <option value="pending" <?= $enrollment['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="confirmed" <?= $enrollment['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                            <option value="cancelled" <?= $enrollment['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Save</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($class['enrollments'])): ?>
                            <tr><td colspan="4" class="text-muted">No students enrolled yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php if (empty($classes)): ?>
    <p class="text-muted">You haven't posted any classes yet.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
