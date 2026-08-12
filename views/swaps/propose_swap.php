<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Propose a Skill Swap</h1>

<form method="POST" action="/swaps/propose" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Trade With (User ID)</label>
        <input type="number" name="requested_by" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Service You're Offering</label>
        <input type="text" name="service_offered" class="form-control" placeholder="e.g. Laptop repair" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Item / Service You Want in Exchange</label>
        <input type="text" name="item_exchanged" class="form-control" placeholder="e.g. Home-cooked meals" required>
    </div>
    <button type="submit" class="btn btn-primary">Propose Swap</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
