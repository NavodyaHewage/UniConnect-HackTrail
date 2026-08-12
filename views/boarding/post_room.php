<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">List a Room</h1>

<form method="POST" action="<?= url('/boarding') ?>" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Rent Amount (LKR)</label>
        <input type="number" step="0.01" name="rent_amount" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Distance from Campus (km)</label>
        <input type="number" step="0.1" name="distance_km" class="form-control" required>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Latitude</label>
            <input type="text" name="latitude" class="form-control">
        </div>
        <div class="col mb-3">
            <label class="form-label">Longitude</label>
            <input type="text" name="longitude" class="form-control">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Publish Listing</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
