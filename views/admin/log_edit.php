<?php require_once "includes/admin_header.php"; ?>

<div class="container my-5">
    <div class="mb-3">
        <h2>Edit Log for <?= $_GET["name"] ?? $logFormData["name"]; ?></h2>
        <p class="fs-5">Date: <?= date("m-d-Y") ?></p>
    </div>

    <form action="/admin/search_log/log_edit" method="POST">
        <div class="mb-4">
            <label for="name" class="form-label fs-5">Name</label>
            <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter name here" value="<?= $logFormData["name"]; ?>">

            <?php if (isset($errors["noNameError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["noNameError"] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="student_id" class="form-label fs-5">Student ID (Optional)</label>
            <input type="text" name="student_id" class="form-control form-control-lg" placeholder="Enter Student ID here (22-0365-456)" value="<?= $logFormData["student_id"]; ?>">
        </div>

        <div class="mb-4">
            <label for="computer_number" class="form-label fs-5">Computer Number</label>
            <input type="number" name="computer_number" class="form-control form-control-lg" placeholder="Enter computer number here" value="<?= $logFormData["computer_number"]; ?>">

            <?php if (isset($errors["noComputerNumberError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["noComputerNumberError"] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="time_in" class="form-label fs-5">Time-In</label>
            <input type="time" name="time_in" class="form-control form-control-lg" value="<?= date("H:i", strtotime($logFormData["time_in"])); ?>">

            <?php if (isset($errors["invalidTimeInError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["invalidTimeInError"] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="time_out" class="form-label fs-5">Time-Out</label>
            <input type="time" name="time_out" class="form-control form-control-lg" value="<?= $logFormData["time_out"]
                                                                                                ? date("H:i", strtotime($logFormData["time_out"] ?? date("H:i")))
                                                                                                : null ?>">

            <?php if (isset($errors["invalidTimeOutError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["invalidTimeOutError"] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Update</button>
            <a href="/admin/search_log" class="btn btn-secondary btn-lg">Cancel</a>
        </div>

        <input type="hidden" name="id" value="<?= $logFormData["id"]; ?>">
    </form>
</div>

<?php require_once "includes/admin_footer.php"; ?>