<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Manage Gigs</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Posted By</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Views</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?= (int) $job['job_id'] ?></td>
                    <td><?= htmlspecialchars($job['title']) ?></td>
                    <td><?= htmlspecialchars($job['poster_name']) ?> (<?= htmlspecialchars($job['poster_phone']) ?>)</td>
                    <td>LKR <?= number_format((float) $job['budget'], 2) ?></td>
                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($job['status']) ?></span></td>
                    <td><?= (int) $job['views'] ?></td>
                    <td>
                        <form method="POST" action="<?= url('/admin/jobs/' . (int) $job['job_id'] . '/delete') ?>" onsubmit="return confirm('Delete this gig?');">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($jobs)): ?>
                <tr><td colspan="7" class="text-muted">No gigs found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
