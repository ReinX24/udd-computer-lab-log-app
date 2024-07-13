<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h1>Are you sure you want delete the current account?</h1>
    <hr>
    <?php if (isset($errors["adminDeleteDenied"])): ?>
        <div class="alert alert-danger mt-4 fs-5">
            Cannot delete admin account!
        </div>
    <?php else: ?>
        <div class="alert alert-danger mt-4 fs-5">
            This will delete the current account permanently!
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped mt-4 fs-5">
        <thead>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Master Account</th>
        </thead>
        <tbody>
            <tr>
                <td><?= $_SESSION["userLoginInfo"]["id"]; ?></td>
                <td><?= $_SESSION["userLoginInfo"]["username"]; ?></td>

                <?php if ($_SESSION["userLoginInfo"]["master_account"]): ?>
                    <td class="text-success"><?= "true" ?></td>
                <?php else: ?>
                    <td class="text-danger"><?= "false" ?></td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>
    <form action="/admin/account/delete_account" method="POST" class="d-flex gap-2">
        <input type="hidden" name="id" value="<?= $_SESSION["userLoginInfo"]["id"]; ?>">
        <button type="submit" class="btn btn-danger btn-lg">Delete</button>
        <a href="/admin/account" class="btn btn-secondary btn-lg">Cancel</a>
    </form>
</div>

<?php require_once "includes/admin_footer.php"; ?>