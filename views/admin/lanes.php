<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Lanes &amp; Agents</h1>

<div class="table-responsive mb-4">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Lane</th>
                <th>Agent</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lanes as $lane): ?>
                <tr>
                    <td><?= htmlspecialchars($lane['lane_name']) ?></td>
                    <td><?= htmlspecialchars($lane['agent_name']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($lanes)): ?>
                <tr><td colspan="2" class="text-muted">No lanes configured yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<form method="POST" action="<?= url('/admin/lanes') ?>" class="col-md-6">
    <h2 class="h5">Add a Lane</h2>
    <div class="mb-3">
        <label class="form-label">Lane Name</label>
        <input type="text" name="lane_name" class="form-control" placeholder="e.g. Lane A - Temple Road" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Assign Agent (Student)</label>
        <select name="agent_id" class="form-select" required>
            <option value="">Select a student</option>
            <?php foreach ($students as $student): ?>
                <option value="<?= (int) $student['user_id'] ?>"><?= htmlspecialchars($student['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Add Lane</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
