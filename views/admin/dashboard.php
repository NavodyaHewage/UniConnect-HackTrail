<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Admin Dashboard</h1>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Users</h2>
                <p class="text-muted"><?= (int) $stats['users'] ?> registered accounts.</p>
                <a href="<?= url('/admin/users') ?>" class="btn btn-sm btn-outline-primary">Manage Users</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Boarding Listings</h2>
                <p class="text-muted"><?= (int) $stats['boardings'] ?> listings total &middot; LKR <?= number_format($stats['ad_revenue'], 2) ?> ad revenue.</p>
                <a href="<?= url('/admin/boardings') ?>" class="btn btn-sm btn-outline-primary">Manage Boardings</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Lanes &amp; Agents</h2>
                <p class="text-muted">Assign student agents to boarding lanes.</p>
                <a href="<?= url('/admin/lanes') ?>" class="btn btn-sm btn-outline-primary">Manage Lanes</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Gigs</h2>
                <p class="text-muted"><?= (int) $stats['jobs'] ?> gigs posted.</p>
                <a href="<?= url('/admin/jobs') ?>" class="btn btn-sm btn-outline-primary">Manage Gigs</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Skills</h2>
                <p class="text-muted">Review and verify submitted skills.</p>
                <a href="<?= url('/admin/skills') ?>" class="btn btn-sm btn-outline-primary">Manage Skills</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Skill Swaps</h2>
                <p class="text-muted"><?= (int) $stats['swaps'] ?> swaps proposed.</p>
                <a href="<?= url('/admin/swaps') ?>" class="btn btn-sm btn-outline-primary">View Swaps</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">New Admin</h2>
                <p class="text-muted">Grant another account admin privileges.</p>
                <a href="<?= url('/admin/create-admin') ?>" class="btn btn-sm btn-outline-primary">Create Admin</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
