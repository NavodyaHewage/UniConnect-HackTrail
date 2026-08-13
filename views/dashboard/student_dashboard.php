<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Student Dashboard</h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Bookings</h2>
                <p class="text-muted">Boarding rooms you've booked.</p>
                <a href="<?= url('/boarding') ?>" class="btn btn-sm btn-outline-primary">Browse Rooms</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Job Applications</h2>
                <p class="text-muted">Gigs you've applied for.</p>
                <a href="<?= url('/jobs/my-applications') ?>" class="btn btn-sm btn-outline-primary">View Applications</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Skill Profile</h2>
                <p class="text-muted">Badges and verified skills.</p>
                <a href="<?= url('/skills/profile/' . (int) $_SESSION['user_id']) ?>" class="btn btn-sm btn-outline-primary">View Profile</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
