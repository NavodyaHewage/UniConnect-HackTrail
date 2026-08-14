<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
    $categoryLabels = ['software' => 'Software & Web Dev', 'hardware' => 'Hardware & Repair', 'general' => 'General Errand'];
    $selectedCategory = $_GET['category'] ?? null;
    $heading = $categoryLabels[$selectedCategory] ?? null;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><?= $heading ? htmlspecialchars($heading) . ' Requests' : 'Help Requests from Villagers' ?></h1>
    <?php if (($_SESSION['user_role'] ?? null) === 'villager'): ?>
        <a href="<?= url('/help-requests/create') ?>" class="btn btn-primary">+ Request a Student</a>
    <?php endif; ?>
</div>
<p class="text-muted">Villagers post tasks they need help with here &mdash; accept one to take it on.</p>

<div class="row g-4">
    <?php foreach ($requests as $request): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-secondary mb-2"><?= htmlspecialchars($categoryLabels[$request['category']] ?? $request['category']) ?></span>
                    <h2 class="h5"><?= htmlspecialchars($request['title']) ?></h2>
                    <p class="text-muted"><?= htmlspecialchars(mb_strimwidth($request['description'], 0, 100, '...')) ?></p>
                    <p class="mb-1">Reward: LKR <?= number_format((float) $request['reward_amount'], 2) ?></p>
                    <p class="text-muted mb-2">Requested by <?= htmlspecialchars($request['villager_name']) ?></p>
                    <a href="<?= url('/help-requests/' . (int) $request['request_id']) ?>" class="btn btn-sm btn-outline-primary">View &amp; Accept</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($requests)): ?>
        <p class="text-muted">No open help requests right now.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
