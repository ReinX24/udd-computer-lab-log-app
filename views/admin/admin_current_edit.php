<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h1>Edit Account</h1>
    <form action="/admin/account/edit_account" method="POST">
        <div class="alert alert-warning fs-5">
            Applying changes will logout account!
        </div>

        <div class="mb-3">
            <div class="mb-3">
                <label for="username" class="form-label fs-5">Username</label>
                <input type="text" name="username" class="form-control form-control-lg" value="<?= $adminData["username"] ?? "" ?>">
            </div>

            <?php if (isset($errors["emptyUsernameError"])): ?>
                <div class="alert alert-danger fs-5">
                    <?= $errors["emptyUsernameError"]; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errors["usernameTakenError"])): ?>
                <div class="alert alert-danger fs-5">
                    <?= $errors["usernameTakenError"]; ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="password" class="form-label fs-5">Password</label>
                <input type="password" name="password" class="form-control form-control-lg">
            </div>

            <?php if (isset($errors["emptyPasswordError"])): ?>
                <div class="alert alert-danger fs-5">
                    <?= $errors["emptyPasswordError"]; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errors["wrongPasswordError"])): ?>
                <div class="alert alert-danger fs-5">
                    <?= $errors["wrongPasswordError"]; ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <input type="checkbox" class="btn-check" id="changePassword" name="changePassword" <?= $adminData["changePassword"] ? "checked" : ""; ?>>
                <label class="btn btn-outline-danger btn-lg" for="changePassword">Change Password</label>
            </div>

            <div class="mb-3">
                <label for="passwordNew" class="form-label fs-5">New Password</label>
                <input type="password" name="passwordNew" class="form-control form-control-lg">
            </div>

            <?php if (isset($errors["emptyPasswordNewError"])): ?>
                <div class="alert alert-danger fs-5">
                    <?= $errors["emptyPasswordNewError"]; ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="passwordNewRepeat" class="form-label fs-5">Repeat New Password</label>
                <input type="password" name="passwordNewRepeat" class="form-control form-control-lg">
            </div>

            <?php if (isset($errors["emptyPasswordRepeatNewError"])): ?>
                <div class="alert alert-danger fs-5">
                    <?= $errors["emptyPasswordRepeatNewError"]; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errors["passwordsNewMismatchError"])): ?>
                <div class="alert alert-danger fs-5">
                    <?= $errors["passwordsNewMismatchError"]; ?>
                </div>
            <?php endif; ?>

            <hr>

            <button class="btn btn-success btn-lg">Apply Changes</button>
            <a href="/admin/account" class="btn btn-secondary btn-lg">Cancel</a>
    </form>
</div>

<?php require_once "includes/admin_footer.php"; ?>