<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h1>Details</h1>
    <hr>

    <?php if (isset($_GET["edited_success"])): ?>
        <div class="alert alert-info alert-dismissible fade show fs-5" role="alert">
            Successfully edited feedback!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped mt-4 fs-5">
        <thead>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Edited</th>
            <th scope="col">Created At</th>
        </thead>
        <tbody>
            <tr>
                <td><?= $feedback["id"]; ?></td>
                <td><?= $feedback["name"]; ?></td>
                <td><?= $feedback["category"]; ?></td>

                <?php if ($feedback["is_edited"]): ?>
                    <td class="text-danger"><?= "true"; ?></td>
                <?php else: ?>
                    <td class="text-success"><?= "false"; ?></td>
                <?php endif; ?>

                <td><?= date("m/d/Y h:i:s A", strtotime($feedback["created_at"])); ?></td>
            </tr>
        </tbody>
    </table>

    <?php if ($_SESSION["userLoginInfo"]["master_account"]): ?>
        <a href="/admin/search/edit?feedbackId=<?= $feedback["id"]; ?>" class="btn btn-primary btn-lg">Edit</a>
    <?php endif; ?>

    <div class="mt-4">
        <label for="feedbackText" class="form-label fs-4">Feedback</label>
        <textarea class="form-control form-control-lg" id="feedbackText" style="height: 12rem;" disabled><?= $feedback["feedback"]; ?></textarea>
    </div>

    <div class="d-flex gap-2 mt-4">
        <?php if ($_SESSION["userLoginInfo"]["master_account"]): ?>
            <form action="/admin/search/delete" method="GET">
                <input type="hidden" name="feedbackId" value="<?= $feedback["id"]; ?>">
                <button type="submit" class="btn btn-danger btn-lg">Delete</button>
            </form>
        <?php endif; ?>

        <a href="/admin/search" class="btn btn-secondary btn-lg">Return</a>
    </div>

</div>

<?php require_once "includes/admin_footer.php"; ?>