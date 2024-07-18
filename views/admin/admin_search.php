<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">

    <?php if (isset($_GET["delete_success"])) : ?>
        <div class="alert alert-danger alert-dismissible fade show fs-5" role="alert">
            Successfully deleted feedback!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="/admin/search" method="GET">
        <div class="d-flex gap-2 my-4">
            <input type="text" name="search_text" class="form-control form-control-lg w-75" placeholder="Enter text here" value="<?= $_GET["search_text"] ?? ""; ?>">
            <button type="submit" class="btn btn-primary btn-lg w-25">Search feedback text</button>
        </div>
    </form>

    <form action="/admin/search" method="GET">
        <div class="d-flex gap-2 my-4">
            <input type="month" name="search_month_and_year" class="form-control form-control-lg w-75" value="<?= $_GET["search_month_and_year"] ?? $currentYearMonth; ?>">
            <button type="submit" class="btn btn-primary btn-lg w-25">Search month & year</button>
        </div>
    </form>

    <form action="/admin/search" method="GET">
        <div class="d-flex gap-2 my-4">
            <input type="date" name="search_date" class="form-control form-control-lg w-75" value="<?= $_GET["search_date"] ?? $currentDayMonthYear; ?>">
            <button type="submit" class="btn btn-primary btn-lg w-25">Search date</button>
        </div>
    </form>

    <form action="/admin/search" method="GET">
        <div class="d-flex gap-2 my-4">
            <select id="categorySelect" name="searchCategory" class="form-select form-select-lg w-75">
                <option value="all" <?= isset($_GET["searchCategory"]) && $_GET["searchCategory"] == "all" ? "selected" : ""; ?>>All</option>
                <option value="books" <?= isset($_GET["searchCategory"]) && $_GET["searchCategory"] == "books" ? "selected" : ""; ?>>Books</option>
                <option value="facilities" <?= isset($_GET["searchCategory"]) && $_GET["searchCategory"] == "facilities" ? "selected" : ""; ?>>Facilities</option>
                <option value="staff" <?= isset($_GET["searchCategory"]) && $_GET["searchCategory"] == "staff" ? "selected" : ""; ?>>Staff</option>
                <option value="miscellaneous" <?= isset($_GET["searchCategory"]) && $_GET["searchCategory"] == "miscellaneous" ? "selected" : ""; ?>>Miscellaneous</option>
            </select>
            <button type="submit" class="btn btn-primary btn-lg w-25">Search category</button>
        </div>

        <div class="d-grid">
            <a href="/admin/search" class="btn btn-danger btn-lg">Reset</a>
        </div>
    </form>

    <hr>

    <?php if (!empty($matchedFeedback)) : ?>
        <table class="table table-bordered table-striped mt-4 fs-5">
            <thead>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Feedback</th>
                <th scope="col">Category</th>
                <th scope="col">Edited</th>
                <th scope="col">Created At</th>
                <th scope="col">Operations</th>
            </thead>
            <tbody>
                <?php foreach ($matchedFeedback as $feedback) : ?>
                    <tr>
                        <td><?= $feedback["id"]; ?></td>
                        <td><?= $feedback["name"]; ?></td>
                        <td><?= strlen($feedback["feedback"]) > 20 ? substr($feedback["feedback"], 0, 20) . "..." : $feedback["feedback"]; ?></td>

                        <?php if ($feedback["category"] == "books") : ?>
                            <td class="text-primary"><?= $feedback["category"]; ?></td>
                        <?php elseif ($feedback["category"] == "facilities") : ?>
                            <td class="text-success"><?= $feedback["category"]; ?></td>
                        <?php elseif ($feedback["category"] == "staff") : ?>
                            <td class="text-danger"><?= $feedback["category"]; ?></td>
                        <?php else : ?>
                            <td class="text-warning-emphasis"><?= $feedback["category"]; ?></td>
                        <?php endif; ?>

                        <?php if ($feedback["is_edited"]) : ?>
                            <td class="text-danger"><?= "true"; ?></td>
                        <?php else : ?>
                            <td class="text-success"><?= "false"; ?></td>
                        <?php endif; ?>

                        <td><?= date("m/d/Y h:i:s A", strtotime($feedback["created_at"])); ?></td>
                        <td>
                            <a href="/admin/search/details?feedbackId=<?= $feedback["id"]; ?>" class="btn btn-secondary btn-lg">Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-info fs-5">
            No matches found.
        </div>
    <?php endif; ?>
</div>

<?php require_once "includes/admin_footer.php"; ?>