<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Request to Become an Agent</h1>

<?php if ($pendingRequest): ?>
    <div class="alert alert-info">
        Your request submitted on <?= htmlspecialchars($pendingRequest['created_at']) ?> is still pending review by an admin.
    </div>
<?php else: ?>
    <form method="POST" action="<?= url('/agent-requests') ?>" class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="tel" name="contact" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">What can you offer as an agent?</label>
            <?php foreach (AgentRequestController::SERVICE_TYPES as $type): ?>
                <div class="form-check">
                    <input type="checkbox" name="service_types[]" value="<?= $type ?>" class="form-check-input" id="service-<?= $type ?>">
                    <label class="form-check-label" for="service-<?= $type ?>"><?= ucfirst($type) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
