<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <div class="container my-5">
        <div class="p-5 text-center bg-body-tertiary rounded-3">

            <?php if ($_SESSION["userLoginInfo"]["master_account"]) : ?>
                <div class="alert alert-primary">
                    <h1 class="text-body-emphasis">Welcome, <span class="text-primary-emphasis"><?= $_SESSION["userLoginInfo"]["username"]; ?></span></h1>
                </div>
            <?php else : ?>
                <div class="alert alert-secondary">
                    <h1 class="text-body-emphasis">Welcome, <span class="text-secondary-emphasis"><?= $_SESSION["userLoginInfo"]["username"]; ?></span></h1>
                </div>
            <?php endif; ?>

            <img src="/images/udd_logo.png" class="mb-4" width="200" height="200">
            <h1 class="text-body-emphasis">UdD Library Feedback Admin Panel</h1>
            <p class="col-lg-8 mx-auto fs-5 text-muted">
                Admin Panel for accessing UdD Library Feedback entries and Admin accounts.
            </p>
            <div class="d-inline-flex gap-2 mb-5">
                <a href="/admin/search">
                    <button class="d-inline-flex align-items-center btn btn-primary btn-lg px-4 rounded-pill" type="button">
                        Search Feedback
                    </button>
                </a>
                <a href="/admin/accounts">
                    <button class="btn btn-outline-secondary btn-lg px-4 rounded-pill" type="button">
                        Admin Accounts
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once "includes/admin_footer.php"; ?>