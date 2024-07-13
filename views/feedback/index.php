<?php require_once "includes/feedback_header.php"; ?>

<?php
// session_start();
// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
?>

<div class="container my-5">
    <div class="p-5 text-center bg-body-tertiary rounded-3">
        <img src="/images/udd_logo.png" class="mb-4" width="200" height="200">
        <h1 class="text-body-emphasis">UdD Library Feedback Form</h1>
        <p class="col-lg-8 mx-auto fs-5 text-muted">
            Submit feedback or suggestions for improving the library of Universidad de Dagupan.
            Any feedback is appreciated!
        </p>
        <div class="d-inline-flex gap-2 mb-5">
            <a href="/feedback/create">
                <button class="d-inline-flex align-items-center btn btn-primary btn-lg px-4 rounded-pill" type="button">
                    Submit Feeback
                </button>
            </a>
            <a href="/feedback/admin_login">
                <button class="btn btn-outline-secondary btn-lg px-4 rounded-pill" type="button">
                    Admin Login
                </button>
            </a>
        </div>
    </div>
</div>

<?php require_once "includes/feedback_footer.php"; ?>