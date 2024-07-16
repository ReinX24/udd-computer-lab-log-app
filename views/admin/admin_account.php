<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h1>Admin Credentials</h1>

    <?php if (isset($_GET["account_success_edit"])) : ?>
        <div class="alert alert-info alert-dismissible fade show fs-5 mt-4" role="alert">
            Successfully edited account!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

                <?php if ($_SESSION["userLoginInfo"]["master_account"]) : ?>
                    <td class="text-success"><?= "true" ?></td>
                <?php else : ?>
                    <td class="text-danger"><?= "false" ?></td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>

    <div class="d-flex gap-2">
        <a href="/admin/account/edit_account" class="btn btn-secondary btn-lg">Edit Account</a>
        <a href="/admin/account/delete_account" class="btn btn-danger btn-lg">Delete Account</a>
    </div>
</div>

<?php require_once "includes/admin_footer.php"; ?>