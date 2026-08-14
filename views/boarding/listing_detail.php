<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($listing): ?>
    <h1 class="h3 mb-3"><?= htmlspecialchars($listing['title']) ?></h1>

    <?php
        $photos = array_filter([
            $listing['photo_path'] ?? null,
            $listing['photo_path_2'] ?? null,
            $listing['photo_path_3'] ?? null,
        ]);
    ?>
    <?php if (!empty($photos)): ?>
        <div class="row g-2 mb-3">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-4">
                    <img src="<?= url($photo) ?>" alt="Boarding photo" class="img-fluid rounded">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($listing['pdf_path'])): ?>
        <p>
            <a href="<?= url($listing['pdf_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                View Photos PDF
            </a>
        </p>
    <?php endif; ?>

    <p><strong>Rent:</strong> LKR <?= number_format((float) $listing['rent_amount'], 2) ?></p>
    <p><strong>Distance from campus:</strong> <?= htmlspecialchars($listing['distance_km']) ?> km</p>
    <p><strong>Status:</strong> <span class="badge bg-<?= $listing['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($listing['status']) ?></span></p>
    <p><strong>Owner:</strong> <?= htmlspecialchars($listing['owner_name']) ?></p>
    <p><strong>Owner Phone:</strong> <?= htmlspecialchars($listing['owner_phone']) ?></p>
    <?php if (!empty($listing['owner_address'])): ?>
        <p><strong>Owner Address:</strong> <?= htmlspecialchars($listing['owner_address']) ?></p>
    <?php endif; ?>
    <?php if (!empty($listing['lane_name'])): ?>
        <p><strong>Lane:</strong> <?= htmlspecialchars($listing['lane_name']) ?></p>
    <?php endif; ?>

    <?php if (($_SESSION['user_id'] ?? null) == $listing['owner_id']): ?>
        <p class="text-muted">Ad posting fee charged for this listing: LKR <?= number_format((float) $listing['ad_fee'], 2) ?></p>
        <form method="POST" action="<?= url('/boarding/' . (int) $listing['boarding_id'] . '/status') ?>">
            <select name="status" class="form-select w-auto d-inline-block">
                <option value="available" <?= $listing['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                <option value="occupied" <?= $listing['status'] === 'occupied' ? 'selected' : '' ?>>Occupied</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
        </form>
        <form method="POST" action="<?= url('/boarding/' . (int) $listing['boarding_id'] . '/delete') ?>" class="mt-2" onsubmit="return confirm('Delete this listing? This cannot be undone.');">
            <button type="submit" class="btn btn-sm btn-danger">Delete Listing</button>
        </form>

        <h2 class="h5 mt-4">Students Who Connected</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
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
                    <?php foreach ($requests as $request): ?>
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
                                        <input type="number" step="0.01" name="tip_amount" class="form-control form-control-sm" placeholder="Tip LKR" style="width:110px" required>
                                        <button type="submit" class="btn btn-sm btn-outline-success">Confirm</button>
                                    </form>
                                    <form method="POST" action="<?= url('/boarding/requests/' . (int) $request['request_id'] . '/decline') ?>" class="mt-1">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Decline</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($requests)): ?>
                        <tr><td colspan="5" class="text-muted">No students have connected with this listing yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (($_SESSION['user_role'] ?? null) === 'student'): ?>
        <?php if ($myRequest): ?>
            <div class="alert alert-info mt-3">
                Your request is currently
                <strong><?= htmlspecialchars($myRequest['status']) ?></strong>.
                <?php if ($myRequest['status'] === 'confirmed'): ?>
                    Your tip of LKR <?= number_format((float) $myRequest['tip_amount'], 2) ?> from the villager has been recorded for your lane agent.
                <?php endif; ?>
            </div>
            <?php if ($myRequest['status'] === 'pending'): ?>
                <form method="POST" action="<?= url('/boarding/requests/' . (int) $myRequest['request_id'] . '/cancel') ?>" onsubmit="return confirm('Cancel this request?');">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancel Request</button>
                </form>
            <?php endif; ?>
        <?php elseif ($listing['status'] === 'available'): ?>
            <form method="POST" action="<?= url('/boarding/' . (int) $listing['boarding_id'] . '/request') ?>" class="col-md-6 mt-4">
                <h2 class="h5">Request to Book</h2>
                <div class="mb-3">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="student_name" class="form-control" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Your Phone Number</label>
                    <input type="tel" name="student_phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message (optional)</label>
                    <textarea name="message" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Connect with Owner</button>
            </form>
        <?php endif; ?>
    <?php elseif (($_SESSION['user_role'] ?? null) === 'villager'): ?>
        <div class="alert alert-secondary mt-3">
            <p class="mb-2">
                This room is listed under <?= htmlspecialchars($listing['owner_name']) ?>'s account. Only <?= htmlspecialchars($listing['owner_name']) ?> can see who has connected and confirm or decline requests for it &mdash; log in as that account to manage it, or view rooms under your own name below.
            </p>
            <a href="<?= url('/boarding/my-listings') ?>" class="btn btn-sm btn-outline-secondary">My Boarding Listings</a>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Listing not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
