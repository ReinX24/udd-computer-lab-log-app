<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h1>Are you sure you want to delete this account?</h1>
    <?php if ($_SESSION["userLoginInfo"]["id"] == $adminData["id"]) : ?>
        <div class="alert alert-danger mt-4 fs-5">
            This will delete the current account!
        </div>
    <?php endif; ?>

    <?php if (isset($errors["adminDeleteDenied"])) : ?>
        <div class="alert alert-danger mt-4 fs-5">
            <?= $errors["adminDeleteDenied"] ?>
        </div>
    <?php endif; ?>

    <hr>
    <table class="table table-bordered table-striped mt-4 fs-5">
        <thead>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Master Account</th>
        </thead>
        <tbody>
            <tr>
                <td><?= $adminData["id"]; ?></td>
                <td><?= $adminData["username"]; ?></td>

                <?php if ($adminData["master_account"]) : ?>
                    <td class="text-success"><?= "true" ?></td>
                <?php else : ?>
                    <td class="text-danger"><?= "false" ?></td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>
    <form action="/admin/accounts/delete" method="POST" class="d-flex gap-2">
        <input type="hidden" name="id" value="<?= $adminData["id"]; ?>">
        <button type="submit" class="btn btn-danger btn-lg">Delete</button>
        <a href="/admin/accounts" class="btn btn-secondary btn-lg">Cancel</a>
    </form>
</div>

<?php require_once "includes/admin_footer.php"; ?>