<?php require_once "includes/log_header.php"; ?>

<div class="container my-5">
    <div class="mb-3">
        <h1>UdD Computer Lab Log</h1>
        <p class="fs-4">Date: <?= date("m-d-Y") ?></p>
    </div>

    <div class="mb-3">
        <a href="/log/log_add" class="btn btn-primary btn-lg">Add Time-In</a>
    </div>

    <!-- Successfully added time-in message -->
    <?php if (isset($_GET["time_in_success"])) : ?>
        <div class="alert alert-success alert-dismissible fade show text-center fs-4" role="alert">
            Successfully timed-in!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Successfully added student id message -->
    <?php if (isset($_GET["add_student_id_success"])) : ?>
        <div class="alert alert-success alert-dismissible fade show text-center fs-4" role="alert">
            Successfully added Student ID!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Successfully added time-out message -->
    <?php if (isset($_GET["time_out_success"])) : ?>
        <div class="alert alert-success alert-dismissible fade show text-center fs-4" role="alert">
            Successfully timed-out!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Successfully edited log message -->
    <?php if (isset($_GET["edit_success"])) : ?>
        <div class="alert alert-secondary alert-dismissible fade show text-center fs-4" role="alert">
            Successfully edited log!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Successfully deleted log message -->
    <?php if (isset($_GET["delete_sucesss"])) : ?>
        <div class="alert alert-danger alert-dismissible fade show text-center fs-4" role="alert">
            Successfully deleted log!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="mb-3 alert alert-primary text-center fs-4">
        Remember to time-out after using a computer.
    </div>

    <table class="table table-striped fs-5">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Student ID</th>
                <th scope="col">Computer</th>
                <th scope="col">Time-In</th>
                <th scope="col">Time-Out</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($currentDayLogs as $eachLog) : ?>
                <tr>
                    <th><?= $eachLog["name"]; ?></th>

                    <!-- Student ID -->
                    <?php if ($eachLog["student_id"]) : ?>
                        <td><?= $eachLog["student_id"]; ?></td>
                    <?php else : ?>
                        <td>
                            <a href="/log/add_student_id?name=<?= $eachLog["name"] ?>&id=<?= $eachLog["id"] ?>" class="btn btn-secondary btn-lg">
                                Add Student ID
                            </a>
                        </td>
                    <?php endif; ?>

                    <td><?= $eachLog["computer_number"]; ?></td>
                    <td><?= date("h:i A", strtotime($eachLog["time_in"])); ?></td>

                    <!-- Time-out -->
                    <?php if ($eachLog["time_out"]) : ?>
                        <td><?= date("h:i A", strtotime($eachLog["time_out"])); ?></td>
                    <?php else : ?>
                        <td>
                            <a href="/log/add_time_out?name=<?= $eachLog["name"]; ?>&id=<?= $eachLog["id"]; ?>" class="btn btn-secondary btn-lg">Add Time-Out</a>
                        </td>
                    <?php endif; ?>

                    <!-- Edit or delete -->
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/log/log_edit?name=<?= $eachLog["name"] ?>&id=<?= $eachLog["id"]; ?>" class="btn btn-secondary btn-lg w-50"><i class="bi bi-pencil-square"></i></a>
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
                                        <form action="/log/log_delete" method="POST">
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
</div>


<?php require_once "includes/log_footer.php"; ?>