<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($job): ?>
    <h1 class="h3 mb-3"><?= htmlspecialchars($job['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
    <p><strong>Budget:</strong> LKR <?= number_format((float) $job['budget'], 2) ?></p>
    <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= htmlspecialchars($job['status']) ?></span></p>

    <?php if ($job['status'] === 'open'): ?>
        <form method="POST" action="/jobs/apply">
            <input type="hidden" name="job_id" value="<?= (int) $job['job_id'] ?>">
            <button type="submit" class="btn btn-primary">Apply for this Gig</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Job not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
