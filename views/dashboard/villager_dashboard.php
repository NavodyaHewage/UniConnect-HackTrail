<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Villager Dashboard</h1>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Boarding Listings</h2>
                <p class="text-muted">See connected students & manage bookings.</p>
                <a href="<?= url('/boarding/my-listings') ?>" class="btn btn-sm btn-outline-primary">View My Listings</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Available Riders</h2>
                <p class="text-muted">Find a student with a bike for a ride.</p>
                <a href="<?= url('/riders') ?>" class="btn btn-sm btn-outline-primary">Browse Riders</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Request a Student</h2>
                <p class="text-muted">Post a task and let a student accept it.</p>
                <a href="<?= url('/help-requests/my') ?>" class="btn btn-sm btn-outline-primary">My Help Requests</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Village Products</h2>
                <p class="text-muted">See buyers & confirm product sales.</p>
                <a href="<?= url('/products/my-listings') ?>" class="btn btn-sm btn-outline-primary">View My Products</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">Learn a New Skill</h2>
                <p class="text-muted">Enroll in classes taught by students.</p>
                <a href="<?= url('/skills/classes') ?>" class="btn btn-sm btn-outline-primary">Browse Classes</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">My Skill Profile</h2>
                <p class="text-muted">Showcase your local skills & badges.</p>
                <a href="<?= url('/skills/profile/' . (int) $_SESSION['user_id']) ?>" class="btn btn-sm btn-outline-primary">View Profile</a>
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

<h2 class="h4 mt-5 mb-3">Gigs Posted by Students</h2>
<div class="row g-4">
    <?php foreach ($openGigs as $gig): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="h5"><?= htmlspecialchars($gig['title']) ?></h3>
                    <p class="text-muted"><?= htmlspecialchars(mb_strimwidth($gig['description'], 0, 100, '...')) ?></p>
                    <p class="mb-1">Budget: LKR <?= number_format((float) $gig['budget'], 2) ?></p>
                    <a href="<?= url('/jobs/' . (int) $gig['job_id']) ?>" class="btn btn-sm btn-outline-primary">View &amp; Apply</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($openGigs)): ?>
        <p class="text-muted">No open gigs from students right now.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
