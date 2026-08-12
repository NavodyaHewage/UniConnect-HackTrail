<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Villager Dashboard</h1>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Listed Rooms</h2>
                <p class="text-muted">Manage rent & room status.</p>
                <a href="<?= url('/boarding/create') ?>" class="btn btn-sm btn-outline-primary">List a Room</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Posted Jobs</h2>
                <p class="text-muted">Local tasks you've posted.</p>
                <a href="<?= url('/jobs/create') ?>" class="btn btn-sm btn-outline-primary">Post a Task</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Ride Offering</h2>
                <p class="text-muted">Toggle tuk-tuk / motorcycle / bicycle availability.</p>
                <a href="<?= url('/rides/offer') ?>" class="btn btn-sm btn-outline-primary">Manage Rides</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Incoming Swap Requests</h2>
                <p class="text-muted">Produce / meals traded for tech help.</p>
                <a href="<?= url('/swaps') ?>" class="btn btn-sm btn-outline-primary">View Swaps</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
