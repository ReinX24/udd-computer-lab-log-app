<?php require_once "includes/log_header.php"; ?>

<div class="container my-5">
    <h2>UdD Library Computer Lab Time-In</h2>
    <form action="/log/log_add" method="POST">
        <div class="mb-4">
            <label for="name" class="form-label fs-5">Name</label>
            <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter name here">

            <?php if (isset($errors["noNameError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["noNameError"] ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="student_id" class="form-label fs-5">Student ID (Optional)</label>
            <input type="text" name="student_id" class="form-control form-control-lg" placeholder="Enter Student ID here (22-0365-456)">
        </div>

        <div class="mb-4">
            <label for="computer_number" class="form-label fs-5">Computer Number</label>
            <input type="number" name="computer_number" class="form-control form-control-lg" placeholder="Enter computer number here">

            <?php if (isset($errors["noComputerNumberError"])) : ?>
                <div class="alert alert-danger fs-5 mt-4">
                    <?= $errors["noComputerNumberError"] ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- TODO: show when PM, only shows AM at the moment -->
        <div class="mb-4">
            <label for="time_in" class="form-label fs-5">Time-In</label>
            <input type="time" name="time_in" class="form-control form-control-lg" value="<?= date("H:i"); ?>" readonly>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            <a href="/log/log_index" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<?php require_once "includes/log_footer.php"; ?>