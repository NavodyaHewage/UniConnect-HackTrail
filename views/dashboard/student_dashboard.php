<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Student Dashboard</h1>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Boarding Rooms</h2>
                <p class="text-muted">Browse rooms and connect with owners.</p>
                <a href="<?= url('/boarding') ?>" class="btn btn-sm btn-outline-primary">Browse Rooms</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Post a Boarding Ad</h2>
                <p class="text-muted">Upload a room ad on behalf of a villager.</p>
                <a href="<?= url('/boarding/create') ?>" class="btn btn-sm btn-outline-primary">Post an Ad</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Boarding Requests</h2>
                <p class="text-muted">Track rooms you've connected with.</p>
                <a href="<?= url('/boarding/my-requests') ?>" class="btn btn-sm btn-outline-primary">View Requests</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Lane Agent Earnings</h2>
                <p class="text-muted">Tips earned from confirmed bookings in your lane.</p>
                <a href="<?= url('/boarding/agent-earnings') ?>" class="btn btn-sm btn-outline-primary">View Earnings</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Rider Profile</h2>
                <p class="text-muted">Show villagers you're available for a ride.</p>
                <a href="<?= url('/riders/my') ?>" class="btn btn-sm btn-outline-primary">Manage Rider Profile</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Help Requests</h2>
                <p class="text-muted">Browse tasks villagers need help with.</p>
                <a href="<?= url('/help-requests') ?>" class="btn btn-sm btn-outline-primary">Browse Requests</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Accepted Requests</h2>
                <p class="text-muted">Tasks you've taken on for villagers.</p>
                <a href="<?= url('/help-requests/my-accepted') ?>" class="btn btn-sm btn-outline-primary">View Accepted</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Village Products</h2>
                <p class="text-muted">Buy raw produce low, resell for a profit.</p>
                <a href="<?= url('/products') ?>" class="btn btn-sm btn-outline-primary">Browse Products</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Product Purchases</h2>
                <p class="text-muted">Track what you've bought from villagers.</p>
                <a href="<?= url('/products/my-purchases') ?>" class="btn btn-sm btn-outline-primary">View Purchases</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Job Applications</h2>
                <p class="text-muted">Gigs you've applied for.</p>
                <a href="<?= url('/jobs/my-applications') ?>" class="btn btn-sm btn-outline-primary">View Applications</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Classes</h2>
                <p class="text-muted">Teach village students & track earnings.</p>
                <a href="<?= url('/skills/classes/my') ?>" class="btn btn-sm btn-outline-primary">Manage Classes</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
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
