<?php require_once "includes/log_header.php"; ?>

<div class="container my-5">
    <div class="mb-3">
        <h2>UdD Computer Lab Log</h2>
        <p class="fs-5">Date: <?= date("m-d-Y") ?></p>
    </div>

    <div class="mb-3">
        <!-- TODO: add time in feature -->
        <a href="/log/log_add" class="btn btn-primary btn-lg">Add Time-In</a>
    </div>

    <div class="mb-3 alert alert-primary text-center fs-4">
        Remember to time-out after using a computer.
    </div>

    <table class="table table-bordered fs-5">
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
                    <!-- <th scope="row"><?= $eachLog["id"]; ?></th> -->
                    <td><?= $eachLog["name"]; ?></td>

                    <!-- Student ID -->
                    <?php if ($eachLog["student_id"]) : ?>
                        <td><?= $eachLog["student_id"]; ?></td>
                    <?php else : ?>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="/log/add_student_id?name=<?= $eachLog["name"] ?>&id=<?= $eachLog["id"] ?>" class="btn btn-secondary btn-lg">
                                    Add Student ID
                                </a>
                            </div>
                        </td>
                    <?php endif; ?>

                    <td><?= $eachLog["computer_number"]; ?></td>
                    <td><?= date("h:i:s A / m-d-Y", strtotime($eachLog["time_in"])); ?></td>

                    <!-- Time-out -->
                    <?php if ($eachLog["time_out"]) : ?>
                        <td><?= $eachLog["time_out"]; ?></td>
                    <?php else : ?>
                        <td>
                            <div class="d-flex justify-content-center">
                                <!-- TODO: add time out function -->
                                <a href="" class="btn btn-secondary btn-lg">Add Time-Out</a>
                            </div>
                        </td>
                    <?php endif; ?>

                    <!-- Edit or delete -->
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <!-- TODO: add edit feature -->
                            <!-- TODO: add delete feature -->
                            <a href="/log/edit_log" class="btn btn-secondary btn-lg w-50"><i class="bi bi-pencil-square"></i></a>
                            <a href="/log/delete_log" class="btn btn-danger btn-lg w-50"><i class="bi bi-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "includes/log_footer.php"; ?>