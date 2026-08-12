<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Request a Ride</h1>

<form method="POST" action="/rides/request" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Driver / Vehicle ID</label>
        <input type="number" name="vehicle_id" class="form-control" required>
        <input type="hidden" name="driver_id" value="">
    </div>
    <div class="mb-3">
        <label class="form-label">Pickup Location</label>
        <input type="text" name="pickup_location" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Drop Location</label>
        <input type="text" name="drop_location" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Fare (LKR)</label>
        <input type="number" step="0.01" name="fare_amount" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Request Ride</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
