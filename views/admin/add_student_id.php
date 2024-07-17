<?php require_once "includes/admin_header.php"; ?>

<div class="container my-5">
    <!-- Get name from GET parameter or $logFormData array -->
    <h2>Add Student ID for <?= $_GET["name"] ?? $logFormData["name"]; ?></h2>
    <form action="/admin/search_log/add_student_id" method="POST">
        <div class="mb-4">
            <label for="student_id" class="form-label fs-5">Student ID</label>
            <input type="text" name="student_id" class="form-control form-control-lg" placeholder="Enter Student ID here (22-0365-456)" value="<?= $logFormData["student_id"] ?? ""; ?>">

            <?php if (isset($errors["noStudentIdError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["noStudentIdError"] ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errors["invalidStudentIdError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["invalidStudentIdError"] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Get id from GET parameter or $logFormData array -->
        <input type="hidden" name="id" value="<?= $_GET["id"] ?? $logFormData["id"]; ?>">

        <input type="hidden" name="name" value="<?= $_GET["name"] ?? $logFormData["name"]; ?>">

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            <a href="/admin/search_log" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<?php require_once "includes/admin_footer.php"; ?>