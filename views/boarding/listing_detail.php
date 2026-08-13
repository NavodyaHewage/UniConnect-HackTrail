<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($listing): ?>
    <h1 class="h3 mb-3"><?= htmlspecialchars($listing['title']) ?></h1>
    <p><strong>Rent:</strong> LKR <?= number_format((float) $listing['rent_amount'], 2) ?></p>
    <p><strong>Distance from campus:</strong> <?= htmlspecialchars($listing['distance_km']) ?> km</p>
    <p><strong>Status:</strong> <span class="badge bg-<?= $listing['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($listing['status']) ?></span></p>

    <?php if (($_SESSION['user_id'] ?? null) == $listing['owner_id']): ?>
        <form method="POST" action="<?= url('/boarding/' . (int) $listing['boarding_id'] . '/status') ?>" class="mb-4">
            <select name="status" class="form-select w-auto d-inline-block">
                <option value="available" <?= $listing['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                <option value="occupied" <?= $listing['status'] === 'occupied' ? 'selected' : '' ?>>Occupied</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
        </form>

        <h2 class="h5 mb-3">Interested Students</h2>
        <?php if (empty($interestedStudents)): ?>
            <p class="text-muted">No one has expressed interest yet.</p>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($interestedStudents as $student): ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="h6 mb-1"><?= htmlspecialchars($student['name']) ?></h3>
                                <p class="mb-1 small"><?= htmlspecialchars($student['phone']) ?></p>
                                <p class="mb-0 small text-muted"><?= htmlspecialchars($student['email']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php elseif (!empty($_SESSION['user_id'])): ?>
        <?php if ($hasExpressedInterest): ?>
            <span class="badge bg-success">You've expressed interest &mdash; the owner can see your contact details</span>
        <?php else: ?>
            <form method="POST" action="<?= url('/boarding/' . (int) $listing['boarding_id'] . '/interest') ?>">
                <button type="submit" class="btn btn-primary">I'm Interested</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p><a href="<?= url('/login') ?>">Log in</a> to let the owner know you're interested.</p>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Listing not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
