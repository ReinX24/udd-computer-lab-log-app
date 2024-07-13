<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h1>Add Admin Account</h1>
    <form action="/admin/accounts/add" method="POST">
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

        <div class="mb-3">
            <label for="repeatPassword" class="form-label fs-5">Re-enter Password</label>
            <input type="password" name="passwordRepeat" class="form-control form-control-lg">
        </div>

        <?php if (isset($errors["emptyPasswordRepeatError"])): ?>
            <div class="alert alert-danger fs-5">
                <?= $errors["emptyPasswordRepeatError"]; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors["passwordsMismatchError"])): ?>
            <div class="alert alert-danger fs-5">
                <?= $errors["passwordsMismatchError"] ?? ""; ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <input type="checkbox" class="btn-check" id="masterAccount" name="masterAccount" <?= $adminData["master_account"] ? "checked" : ""; ?>>
            <label class="btn btn-outline-primary btn-lg" for="masterAccount">Master Account</label>
        </div>

        <hr>

        <div class="d-flex gap-2">
            <button class="btn btn-success btn-lg">Add Account</button>
            <a href="/admin/accounts" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<?php require_once "includes/admin_footer.php"; ?>