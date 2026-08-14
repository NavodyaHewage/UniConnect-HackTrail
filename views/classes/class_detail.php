<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if ($class): ?>
    <span class="badge bg-<?= $class['class_type'] === 'group' ? 'info text-dark' : 'secondary' ?> mb-2">
        <?= $class['class_type'] === 'group' ? 'Group Class' : 'Individual Class' ?>
    </span>
    <h1 class="h3 mb-3"><?= htmlspecialchars($class['title']) ?></h1>
    <p><strong>Subject:</strong> <?= htmlspecialchars($class['subject']) ?></p>
    <?php if (!empty($class['description'])): ?>
        <p><?= nl2br(htmlspecialchars($class['description'])) ?></p>
    <?php endif; ?>
    <p><strong>Price:</strong> LKR <?= number_format((float) $class['price'], 2) ?> per student</p>
    <?php if (!empty($class['schedule'])): ?>
        <p><strong>Schedule:</strong> <?= htmlspecialchars($class['schedule']) ?></p>
    <?php endif; ?>
    <p><strong>Seats:</strong> <?= (int) $seatsTaken ?> / <?= (int) $class['max_students'] ?> taken</p>
    <p><strong>Status:</strong> <span class="badge bg-<?= $class['status'] === 'open' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($class['status']) ?></span></p>
    <p><strong>Tutor:</strong> <?= htmlspecialchars($class['tutor_name']) ?></p>
    <p><strong>Tutor Phone:</strong> <?= htmlspecialchars($class['tutor_phone']) ?></p>

    <?php if (($_SESSION['user_id'] ?? null) == $class['tutor_id']): ?>
        <h2 class="h5 mt-4">Enrolled Students</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr>
                            <td><?= htmlspecialchars($enrollment['student_name']) ?></td>
                            <td><?= htmlspecialchars($enrollment['student_phone']) ?></td>
                            <td><?= htmlspecialchars($enrollment['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($enrollments)): ?>
                        <tr><td colspan="3" class="text-muted">No students enrolled yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <a href="<?= url('/skills/classes/my') ?>" class="btn btn-sm btn-outline-secondary">Manage in My Classes</a>
    <?php elseif (($_SESSION['user_role'] ?? null) === 'villager' && $class['status'] === 'open'): ?>
        <form method="POST" action="<?= url('/skills/classes/' . (int) $class['class_id'] . '/enroll') ?>" class="col-md-6 mt-4">
            <h2 class="h5">Enroll in this Class</h2>
            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <input type="text" name="student_name" class="form-control" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Your Phone Number</label>
                <input type="tel" name="student_phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Enroll</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p class="text-muted">Class not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
