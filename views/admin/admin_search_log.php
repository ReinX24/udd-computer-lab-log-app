<?php require_once "includes/admin_header.php"; ?>

<div class="container mt-4">
    <h2>Admin Search Log</h2>

    <form action="/admin/search_log" method="GET">
        <div class="d-flex gap-2 my-4">
            <input type="text" name="search_name" class="form-control form-control-lg w-75" placeholder="Enter name here" value="<?= $_GET["search_name"] ?? ""; ?>">
            <button type="submit" class="btn btn-primary btn-lg w-25">Search name</button>
        </div>
    </form>

    <form action="/admin/search_log" method="GET">
        <div class="d-flex gap-2 my-4">
            <input type="text" name="search_student_id" class="form-control form-control-lg w-75" placeholder="Enter student ID here" value="<?= $_GET["search_student_id"] ?? ""; ?>">
            <button type="submit" class="btn btn-primary btn-lg w-25">Search student ID</button>
        </div>
    </form>

    <hr>

    <h2>Search Time-In</h2>
    <form action="/admin/search_log" method="GET">
        <div class="d-flex gap-2 my-4">
            <input type="month" name="search_month_and_year" class="form-control form-control-lg w-75" value="<?= $_GET["search_month_and_year"] ?? $currentYearMonth; ?>">
            <button type="submit" class="btn btn-primary btn-lg w-25">Search month & year</button>
        </div>
    </form>

    <form action="/admin/search_log" method="GET">
        <div class="d-flex gap-2 my-4">
            <input type="date" name="search_date" class="form-control form-control-lg w-75" value="<?= $_GET["search_date"] ?? $currentDayMonthYear; ?>">
            <button type="submit" class="btn btn-primary btn-lg w-25">Search date</button>
        </div>
    </form>

    <div class="d-flex mb-4">
        <a href="/admin/search_log" class="btn btn-danger btn-lg w-100">
            Reset
        </a>
    </div>

    <?php if (!empty($matchedLogs)) : ?>
        <table class="table table-striped fs-5">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Student ID</th>
                    <th scope="col">Computer</th>
                    <th scope="col">Time-In</th>
                    <th scope="col">Time-Out</th>
                    <th scope="col">Created At</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matchedLogs as $eachLog) : ?>
                    <tr>
                        <th scope="row"><?= $eachLog["id"]; ?></th>
                        <td><?= $eachLog["name"]; ?></td>

                        <!-- Student ID -->
                        <?php if ($eachLog["student_id"]) : ?>
                            <td><?= $eachLog["student_id"]; ?></td>
                        <?php else : ?>
                            <td>
                                <a href="/admin/search_log/add_student_id?name=<?= $eachLog["name"] ?>&id=<?= $eachLog["id"] ?>" class="btn btn-secondary btn-lg">
                                    Add Student ID
                                </a>
                            </td>
                        <?php endif; ?>

                        <td><?= $eachLog["computer_number"]; ?></td>
                        <td><?= date("h:i:s A / m-d-Y", strtotime($eachLog["time_in"])); ?></td>

                        <!-- Time-out -->
                        <?php if ($eachLog["time_out"]) : ?>
                            <td><?= date("h:i:s A m-d-Y", strtotime($eachLog["time_out"])); ?></td>
                        <?php else : ?>
                            <td>
                                <a href="/admin/search_log/add_time_out?name=<?= $eachLog["name"]; ?>&id=<?= $eachLog["id"]; ?>" class="btn btn-secondary btn-lg">Add Time-Out</a>
                            </td>
                        <?php endif; ?>

                        <td><?= date("h:i:s A / m-d-Y", strtotime($eachLog["created_at"])); ?></td>

                        <!-- Edit or delete -->
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- TODO: test edit feature -->
                                <a href="/admin/search_log/log_edit?name=<?= $eachLog["name"] ?>&id=<?= $eachLog["id"]; ?>" class="btn btn-secondary btn-lg w-50"><i class="bi bi-pencil-square"></i></a>
                                <!-- Delete trigger modal -->
                                <button type="button" class="btn btn-danger btn-lg w-50" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $eachLog["id"]; ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Delete -->
                            <div class="modal fade" id="deleteModal<?= $eachLog["id"]; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Modal</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body fs-5">
                                            Are you sure you want to delete log of <?= $eachLog["name"]; ?>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                            <!-- Delete log by passing in the id -->
                                            <form action="/admin/search_log/log_delete" method="POST">
                                                <input type="hidden" name="id" value="<?= $eachLog["id"]; ?>">
                                                <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of delete modal -->

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-light fs-5" role="alert">
            No matches found.
        </div>
    <?php endif; ?>

</div>

<?php require_once "includes/admin_footer.php"; ?>