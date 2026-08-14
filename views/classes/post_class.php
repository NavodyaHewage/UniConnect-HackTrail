<?php require __DIR__ . '/../layout/header.php'; ?>

<h1 class="h3 mb-4">Post a Class</h1>

<form method="POST" action="<?= url('/skills/classes') ?>" class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" name="tutor_name" class="form-control" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Your Phone Number</label>
        <input type="tel" name="tutor_phone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Subject</label>
        <input type="text" name="subject" class="form-control" placeholder="e.g. Mathematics, English, Basic Programming" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Class Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Class Type</label>
        <select name="class_type" id="classType" class="form-select">
            <option value="individual">Individual (1-on-1)</option>
            <option value="group">Group</option>
        </select>
    </div>
    <div class="mb-3" id="maxStudentsField" style="display:none;">
        <label class="form-label">Max Students</label>
        <input type="number" min="2" name="max_students" class="form-control" value="5">
    </div>
    <div class="mb-3">
        <label class="form-label">Price per Student (LKR)</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Schedule</label>
        <input type="text" name="schedule" class="form-control" placeholder="e.g. Mon & Wed, 5-6 PM">
    </div>
    <button type="submit" class="btn btn-primary">Publish Class</button>
</form>

<script>
    const classTypeSelect = document.getElementById('classType');
    const maxStudentsField = document.getElementById('maxStudentsField');
    classTypeSelect.addEventListener('change', () => {
        maxStudentsField.style.display = classTypeSelect.value === 'group' ? 'block' : 'none';
    });
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
