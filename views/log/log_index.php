<?php require_once "includes/log_header.php"; ?>

<div class="container my-5">
    <div class="mb-3">
        <h2>UdD Computer Lab Log</h2>
        <p class="fs-5">Date: <?= date("m-d-Y") ?></p>
    </div>

    <div class="mb-3">
        <!-- TODO: add time in feature -->
        <a href="/log/add_log" class="btn btn-primary btn-lg">Add Time-In</a>
    </div>

    <div class="mb-3 alert alert-primary">
        Note:
    </div>

    <table class="table table-bordered fs-5">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Student ID</th>
                <th scope="col">Time-In</th>
                <th scope="col">Time-Out</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($currentDayLogs as $eachLog) : ?>
                <tr>
                    <th scope="row"><?= $eachLog["id"]; ?></th>
                    <td><?= $eachLog["name"]; ?></td>

                    <!-- Student ID -->
                    <?php if (isset($eachLog["student_id"])) : ?>
                        <td><?= $eachLog["student_id"]; ?></td>
                    <?php else : ?>
                        <td class="text-danger">NO STUDENT ID</td>
                    <?php endif; ?>

                    <td><?= $eachLog["time_in"]; ?></td>

                    <!-- Time-out -->
                    <?php if (isset($eachLog["time_out"])) : ?>
                        <td><?= $eachLog["time_out"]; ?></td>
                    <?php else : ?>
                        <td class="text-danger">NO TIME-OUT RECORDED</td>
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