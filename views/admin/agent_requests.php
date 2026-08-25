<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Agent Requests</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Requested Services</th>
                <th>Status</th>
                <th>Submitted</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agentRequests as $request): ?>
                <tr>
                    <td><?= (int) $request['request_id'] ?></td>
                    <td><?= htmlspecialchars($request['name']) ?></td>
                    <td><?= htmlspecialchars($request['email']) ?></td>
                    <td><?= htmlspecialchars($request['contact']) ?></td>
                    <td><?= htmlspecialchars(implode(', ', array_map('ucfirst', explode(',', $request['service_types'])))) ?></td>
                    <td>
                        <?php
                            $badge = ['pending' => 'secondary', 'approved' => 'success', 'rejected' => 'danger'][$request['status']];
                        ?>
                        <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($request['status']) ?></span>
                    </td>
                    <td><?= htmlspecialchars($request['created_at']) ?></td>
                    <td>
                        <?php if ($request['status'] === 'pending'): ?>
                            <div class="d-flex gap-2">
                                <form method="POST" action="<?= url('/admin/agent-requests/' . (int) $request['request_id'] . '/approve') ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form method="POST" action="<?= url('/admin/agent-requests/' . (int) $request['request_id'] . '/reject') ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($agentRequests)): ?>
                <tr><td colspan="8" class="text-muted">No agent requests found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
