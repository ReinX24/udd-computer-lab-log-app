<?php require_once "includes/log_header.php"; ?>

<div class="container my-5">
    <h1>Add time-out for <?= $_GET["name"] ?? $logFormData["name"]; ?></h1>
    <form action="/log/add_time_out" method="POST">
        <div class="mb-4">
            <label for="time_out" class="form-label fs-4">Time-Out (Current Time)</label>
            <input type="time" name="time_out" class="form-control form-control-lg" value="<?= date("H:i"); ?>" readonly>
        </div>

        <!-- Get id from GET parameter or $logFormData array -->
        <input type="hidden" name="id" value="<?= $_GET["id"] ?? $logFormData["id"]; ?>">

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            <a href="/log/log_index" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<?php require_once "includes/log_footer.php"; ?>