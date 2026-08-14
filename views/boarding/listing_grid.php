<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Boarding Listings</h1>
    <?php if (($_SESSION['user_role'] ?? null) === 'student'): ?>
        <a href="<?= url('/boarding/create') ?>" class="btn btn-primary">+ Post a Boarding Ad</a>
    <?php endif; ?>
</div>

<form method="GET" action="<?= url('/boarding') ?>" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="Search by title..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </div>
    <div class="col-auto">
        <input type="number" step="0.1" name="max_distance" class="form-control" placeholder="Max distance (km)" value="<?= htmlspecialchars($_GET['max_distance'] ?? '') ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
    </div>
    <?php if (($_GET['search'] ?? '') !== '' || ($_GET['max_distance'] ?? '') !== ''): ?>
        <div class="col-auto">
            <a href="<?= url('/boarding') ?>" class="btn btn-outline-secondary">Clear</a>
        </div>
    <?php endif; ?>
</form>

<div class="row g-4">
    <?php foreach ($listings as $listing): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <?php if (!empty($listing['photo_path'])): ?>
                    <img src="<?= url($listing['photo_path']) ?>" alt="Boarding photo" class="card-img-top" style="height:180px;object-fit:cover;">
                <?php endif; ?>
                <div class="card-body">
                    <h2 class="h5"><?= htmlspecialchars($listing['title']) ?></h2>
                    <p class="mb-1">Rent: LKR <?= number_format((float) $listing['rent_amount'], 2) ?></p>
                    <p class="mb-1">Distance: <?= htmlspecialchars($listing['distance_km']) ?> km</p>
                    <p class="text-muted">Owner: <?= htmlspecialchars($listing['owner_name']) ?> (<?= htmlspecialchars($listing['owner_phone']) ?>)</p>
                    <a href="<?= url('/boarding/' . (int) $listing['boarding_id']) ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($listings)): ?>
        <p class="text-muted">
            <?= (($_GET['search'] ?? '') !== '' || ($_GET['max_distance'] ?? '') !== '')
                ? 'No listings match your filters.'
                : 'No listings available right now.' ?>
        </p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
