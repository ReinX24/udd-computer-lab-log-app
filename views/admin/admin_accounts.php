<?php require_once "includes/admin_header.php"; ?>

<?php
// echo "<pre>";
// var_dump($adminData);
// echo "</pre>";
?>

<div class="container mt-4">
    <h1>Admin Accounts</h1>

    <?php if ($_SESSION["userLoginInfo"]["master_account"]): ?>
        <a href="/admin/accounts/add" class="btn btn-primary btn-lg">
            Add Account
        </a>
    <?php endif; ?>

    <?php if (isset($_GET["account_success_add"])): ?>
        <div class="alert alert-success alert-dismissible fade show fs-5 mt-4" role="alert">
            Successfully added account!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET["account_success_edit"])): ?>
        <div class="alert alert-info alert-dismissible fade show fs-5 mt-4" role="alert">
            Successfully edited account!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET["account_success_delete"])): ?>
        <div class="alert alert-danger alert-dismissible fade show fs-5 mt-4" role="alert">
            Successfully deleted account!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped mt-4 fs-5">
        <thead>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <?php if ($_SESSION["userLoginInfo"]["master_account"]): ?>
                <th scope="col">Master Account</th>
                <th scope="col">Operations</th>
            <?php endif; ?>
        </thead>
        <tbody>
            <?php foreach ($adminData as $admin): ?>
                <tr>
                    <?php if ($_SESSION["userLoginInfo"]["master_account"]): ?>
                        <td><?= $admin["id"]; ?></td>

                        <td><?= $admin["username"]; ?>
                            <?= $_SESSION["userLoginInfo"]["username"] == $admin["username"] ? "(current)" : ""; ?>
                        </td>

                        <?php if ($admin["master_account"]): ?>
                            <td class="text-success"><?= "true" ?></td>
                        <?php else: ?>
                            <td class="text-danger"><?= "false" ?></td>
                        <?php endif; ?>

                        <td>
                            <div class="d-flex gap-2">
                                <a href="/admin/accounts/delete?id=<?= $admin["id"]; ?>" class="btn btn-danger btn-lg">Delete</a>
                                <a href="/admin/accounts/edit?id=<?= $admin["id"]; ?>" class="btn btn-secondary btn-lg">Edit</a>
                            </div>
                        </td>
                    <?php else: ?>
                        <td><?= $admin["id"]; ?></td>
                        <td><?= $admin["username"]; ?>
                            <?= $_SESSION["userLoginInfo"]["username"] == $admin["username"] ? "(current)" : ""; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "includes/admin_footer.php"; ?>