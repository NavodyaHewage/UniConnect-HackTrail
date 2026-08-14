<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if ($product): ?>
    <?php
        $categoryLabels = ['spices' => 'Spices', 'tea' => 'Tea Leaves', 'mushroom' => 'Mushroom', 'vegetables' => 'Vegetables', 'fruits' => 'Fruits', 'other' => 'Other'];
    ?>
    <span class="badge bg-secondary mb-2"><?= htmlspecialchars($categoryLabels[$product['category']] ?? $product['category']) ?></span>
    <h1 class="h3 mb-3"><?= htmlspecialchars($product['product_name']) ?></h1>
    <?php if (!empty($product['description'])): ?>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
    <?php endif; ?>
    <p><strong>Price:</strong> LKR <?= number_format((float) $product['price_per_unit'], 2) ?> per <?= htmlspecialchars($product['unit']) ?></p>
    <p><strong>Available Quantity:</strong> <?= rtrim(rtrim(number_format((float) $product['quantity_available'], 2), '0'), '.') ?> <?= htmlspecialchars($product['unit']) ?></p>
    <?php if (!empty($product['lane_name'])): ?>
        <p><strong>Lane:</strong> <?= htmlspecialchars($product['lane_name']) ?></p>
    <?php endif; ?>
    <p><strong>Status:</strong> <span class="badge bg-<?= $product['status'] === 'available' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($product['status']) ?></span></p>
    <p><strong>Seller:</strong> <?= htmlspecialchars($product['owner_name']) ?></p>
    <p><strong>Seller Phone:</strong> <?= htmlspecialchars($product['owner_phone']) ?></p>

    <?php if (($_SESSION['user_id'] ?? null) == $product['owner_id']): ?>
        <h2 class="h5 mt-4">Students Interested in Buying</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Phone</th>
                        <th>Quantity</th>
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
                            <td><?= rtrim(rtrim(number_format((float) $request['quantity_requested'], 2), '0'), '.') ?> <?= htmlspecialchars($product['unit']) ?></td>
                            <td><?= htmlspecialchars($request['message'] ?? '') ?></td>
                            <td>
                                <span class="badge bg-<?= $request['status'] === 'confirmed' ? 'success' : ($request['status'] === 'declined' ? 'secondary' : 'warning text-dark') ?>">
                                    <?= htmlspecialchars($request['status']) ?>
                                </span>
                                <?php if ($request['status'] === 'confirmed'): ?>
                                    <div class="small text-muted">Total: LKR <?= number_format((float) $request['total_price'], 2) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($request['status'] === 'pending'): ?>
                                    <form method="POST" action="<?= url('/products/requests/' . (int) $request['request_id'] . '/confirm') ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-success">Confirm Sale</button>
                                    </form>
                                    <form method="POST" action="<?= url('/products/requests/' . (int) $request['request_id'] . '/decline') ?>" class="mt-1">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Decline</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($requests)): ?>
                        <tr><td colspan="6" class="text-muted">No students have requested this product yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (($_SESSION['user_role'] ?? null) === 'student'): ?>
        <?php if ($myRequest): ?>
            <div class="alert alert-info mt-3">
                Your request for <?= rtrim(rtrim(number_format((float) $myRequest['quantity_requested'], 2), '0'), '.') ?> <?= htmlspecialchars($product['unit']) ?> is currently
                <strong><?= htmlspecialchars($myRequest['status']) ?></strong>.
                <?php if ($myRequest['status'] === 'confirmed'): ?>
                    Total price: LKR <?= number_format((float) $myRequest['total_price'], 2) ?>. Arrange pickup with the seller.
                <?php endif; ?>
            </div>
        <?php elseif ($product['status'] === 'available'): ?>
            <form method="POST" action="<?= url('/products/' . (int) $product['product_id'] . '/request') ?>" class="col-md-6 mt-4">
                <h2 class="h5">Request to Buy</h2>
                <div class="mb-3">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="student_name" class="form-control" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Your Phone Number</label>
                    <input type="tel" name="student_phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity (<?= htmlspecialchars($product['unit']) ?>)</label>
                    <input type="number" step="0.01" min="0.01" name="quantity_requested" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message (optional)</label>
                    <textarea name="message" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Request to Buy</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Product not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
