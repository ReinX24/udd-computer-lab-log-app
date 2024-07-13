<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h1>Edit Feedback</h1>
    <hr>
    <form action="/admin/search/edit" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label fs-5">Name (Optional)</label>
            <input type="text" name="name" placeholder="Enter name here" class="form-control form-control-lg" value="<?= $feedback["name"] ?? "" ?>">
        </div>

        <div class="mb-3">
            <label for="categorySelect" class="form-label fs-5">Category</label>
            <select id="categorySelect" name="categorySelect" class="form-select form-select-lg">
                <option value="books" <?= $feedback["category"] == "books" ? "selected" : ""; ?>>Books</option>
                <option value="facilities" <?= $feedback["category"] == "facilities" ? "selected" : ""; ?>>Facilities</option>
                <option value="staff" <?= $feedback["category"] == "staff" ? "selected" : ""; ?>>Staff</option>
                <option value="misc" <?= $feedback["category"] == "misc" ? "selected" : ""; ?>>Miscellaneous</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="feedbackText" class="form-label fs-5">Feedback</label>
            <textarea id="feedbackText" name="feedbackText" placeholder="Enter feedback here" class="form-control form-control-lg" style="height: 200px;"><?= $feedback["feedback"] ?></textarea>
        </div>

        <?php if (isset($errors["feedbackTextError"])): ?>
            <div class="alert alert-danger fs-5">
                <?= $errors["feedbackTextError"]; ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?= $feedback["id"]; ?>">
        <input type="hidden" name="created_at" value="<?= $feedback["created_at"]; ?>">

        <div class="d-flex gap-2 mt-4">
            <button type="submit" name="feedback_submit" value="submit" class="btn btn-success btn-lg">Apply</button>
            <a href="/admin/search/details?feedbackId=<?= $feedback["id"]; ?>" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<?php require_once "includes/admin_footer.php"; ?>