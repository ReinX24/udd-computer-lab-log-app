<?php require_once "includes/log_header.php"; ?>

<div class="container my-5">
    <div class="p-5 text-center bg-body-tertiary rounded-3">
        <img src="/images/udd_logo.png" class="mb-4" width="200" height="200">
        <h1 class="text-body-emphasis">UdD Computer Lab Log</h1>
        <p class="col-lg-8 mx-auto fs-5 text-muted">
            Logging time-ins, time-outs, and more from students when using the
            computer lab of the UdD Library.
        </p>
        <div class="d-inline-flex gap-2 mb-5">
            <a href="/log/log_index">
                <button class="d-inline-flex align-items-center btn btn-primary btn-lg px-4 rounded-pill" type="button">
                    Time-in | Time-out
                </button>
            </a>
            <a href="/log/admin_login">
                <button class="btn btn-outline-secondary btn-lg px-4 rounded-pill" type="button">
                    Admin Login
                </button>
            </a>
        </div>
    </div>
</div>

<?php require_once "includes/log_footer.php"; ?>