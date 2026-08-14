<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">My Boarding Listings</h1>

<p class="text-muted">These are the rooms listed under your name. A student agent uploads new ads on your behalf &mdash; each listing below shows every student who has connected, so you can confirm or decline right here.</p>

<?php foreach ($listings as $listing): ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <h2 class="h5 mb-1"><?= htmlspecialchars($listing['title']) ?></h2>
                    <p class="mb-1 text-muted">
                        Rent: LKR <?= number_format((float) $listing['rent_amount'], 2) ?>
                        <?php if (!empty($listing['lane_name'])): ?>
                            &middot; <?= htmlspecialchars($listing['lane_name']) ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <form method="POST" action="<?= url('/boarding/' . (int) $listing['boarding_id'] . '/status') ?>">
                        <select name="status" class="form-select form-select-sm d-inline-block w-auto">
                            <option value="available" <?= $listing['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="occupied" <?= $listing['status'] === 'occupied' ? 'selected' : '' ?>>Occupied</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                    </form>
                    <a href="<?= url('/boarding/' . (int) $listing['boarding_id']) ?>" class="btn btn-sm btn-outline-secondary">View Listing</a>
                </div>
            </div>

            <h3 class="h6 mt-3 mb-2">Students Who Connected</h3>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listing['requests'] as $request): ?>
                            <tr>
                                <td><?= htmlspecialchars($request['student_name']) ?></td>
                                <td><?= htmlspecialchars($request['student_phone']) ?></td>
                                <td><?= htmlspecialchars($request['message'] ?? '') ?></td>
                                <td>
                                    <span class="badge bg-<?= $request['status'] === 'confirmed' ? 'success' : ($request['status'] === 'declined' ? 'secondary' : 'warning text-dark') ?>">
                                        <?= htmlspecialchars($request['status']) ?>
                                    </span>
                                    <?php if ($request['status'] === 'confirmed'): ?>
                                        <div class="small text-muted">Tip: LKR <?= number_format((float) $request['tip_amount'], 2) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($request['status'] === 'pending'): ?>
                                        <form method="POST" action="<?= url('/boarding/requests/' . (int) $request['request_id'] . '/confirm') ?>" class="d-flex gap-1">
                                            <input type="number" step="0.01" name="tip_amount" class="form-control form-control-sm" placeholder="Tip LKR" style="width:100px" required>
                                            <button type="submit" class="btn btn-sm btn-outline-success">Approve</button>
                                        </form>
                                        <form method="POST" action="<?= url('/boarding/requests/' . (int) $request['request_id'] . '/decline') ?>" class="mt-1">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Decline</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($listing['requests'])): ?>
                            <tr><td colspan="5" class="text-muted">No students have connected with this listing yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php if (empty($listings)): ?>
    <p class="text-muted">No rooms have been listed under your name yet.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
