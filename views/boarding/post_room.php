<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Post a Boarding Ad</h1>
<p class="text-muted">Villagers can't post ads themselves &mdash; as a student, you're uploading this ad on behalf of the villager who owns the room.</p>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error_message']) ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>


<form method="POST" action="<?= url('/boarding/create') ?>" class="col-md-6" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Villager (Owner)</label>
        <select name="villager_id" class="form-select" required>
            <option value="">Select the villager who owns this room</option>
            <?php foreach ($villagers as $villager): ?>
                <option value="<?= (int) $villager['user_id'] ?>"><?= htmlspecialchars($villager['name']) ?> (<?= htmlspecialchars($villager['phone']) ?>)</option>
            <?php endforeach; ?>
        </select>
        <div class="form-text">
            The selected villager becomes the listing owner &mdash; they'll see connecting students and confirm/decline bookings.
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Owner's Address</label>
        <input type="text" name="owner_address" class="form-control">
    </div>
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
    <div class="mb-3">
        <label class="form-label">Lane</label>
        <select name="lane_id" class="form-select">
            <option value="">Not on a covered lane</option>
            <?php foreach ($lanes as $lane): ?>
                <option value="<?= (int) $lane['lane_id'] ?>"><?= htmlspecialchars($lane['lane_name']) ?> (agent: <?= htmlspecialchars($lane['agent_name']) ?>)</option>
            <?php endforeach; ?>
        </select>
        <div class="form-text">
            Picking a lane assigns that lane's student agent to earn a tip when a booking through them is confirmed.
        </div>
    </div>
    <div class="alert alert-info py-2 px-3 mb-3">
        A flat LKR 500.00 ad posting fee applies when you publish this listing.
    </div>
    <div class="mb-3">
        <label for="boarding_photo" class="form-label">Photo 1</label>
        <input class="form-control" type="file" id="boarding_photo" name="boarding_photo" accept="image/png">
        <div id="photoHelp" class="form-text">
            Please upload a PNG image (max 2MB).
        </div>
    </div>
    <div class="mb-3">
        <label for="boarding_photo_2" class="form-label">Photo 2</label>
        <input class="form-control" type="file" id="boarding_photo_2" name="boarding_photo_2" accept="image/png">
    </div>
    <div class="mb-3">
        <label for="boarding_photo_3" class="form-label">Photo 3</label>
        <input class="form-control" type="file" id="boarding_photo_3" name="boarding_photo_3" accept="image/png">
    </div>
    <div class="mb-3">
        <label for="boarding_pdf" class="form-label">Photos PDF (optional)</label>
        <input class="form-control" type="file" id="boarding_pdf" name="boarding_pdf" accept="application/pdf">
        <div class="form-text">
            Upload a PDF containing additional pictures of the room (max 5MB).
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Publish Listing</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
