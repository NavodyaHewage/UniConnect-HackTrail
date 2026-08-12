<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Boarding Listings</h1>
    <a href="<?= url('/boarding/create') ?>" class="btn btn-primary">+ List a Room</a>
</div>

<form method="GET" action="<?= url('/boarding') ?>" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="Search by title...">
    </div>
    <div class="col-auto">
        <input type="number" step="0.1" name="max_distance" class="form-control" placeholder="Max distance (km)">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
    </div>
</form>

<div class="row g-4">
    <?php foreach ($listings as $listing): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5"><?= htmlspecialchars($listing['title']) ?></h2>
                    <p class="mb-1">Rent: LKR <?= number_format((float) $listing['rent_amount'], 2) ?></p>
                    <p class="mb-1">Distance: <?= htmlspecialchars($listing['distance_km']) ?> km</p>
                    <p class="text-muted">Owner: <?= htmlspecialchars($listing['owner_name']) ?></p>
                    <a href="<?= url('/boarding/' . (int) $listing['boarding_id']) ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($listings)): ?>
        <p class="text-muted">No listings available right now.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
