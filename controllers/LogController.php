<?php

declare(strict_types=1);

namespace app\controllers;

date_default_timezone_set('Asia/Manila');

use app\Router;
use app\models\Log;


/**
 * Class for redirecting the user in the udd-computer-lab-log-app
 */
class LogController
{
    public function index(Router $router)
    {
        $router->renderView(
            "log/index",
            ["currentPage" => "index"]
        );
    }

    public function log_index(Router $router)
    {
        $currentDate = date("Y-m-d");
        $logData = new Log();

        $currentDayLogs = $logData->getCurrentDayLogs($currentDate);

        // Get all logs for the existing day
        $router->renderView(
            "log/log_index",
            [
                "currentPage" => "logIndex",
                "currentDayLogs" => $currentDayLogs
            ]
        );
    }

    public function log_add(Router $router)
    {
        $errors = [];

        $logFormData = [
            "name" => null,
            "student_id" => null,
            "computer_number" => null,
            "time_in" => null
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $logFormData["name"] = $_POST["name"];
            $logFormData["student_id"] = $_POST["student_id"];
            $logFormData["computer_number"] = $_POST["computer_number"];
            $logFormData["time_in"] = date("Y-m-d H:i:s"); // get current date

            $log = new Log();
            $log->load($logFormData);
            $errors = $log->save();

            if (empty($errors)) {
                header("Location: /log/log_index");
                exit;
            }
        }

        $router->renderView(
            "log/log_add",
            [
                "currentPage" => "logIndex",
                "logFormData" => $logFormData,
                "errors" => $errors
            ]
        );
    }
    public function add_student_id(Router $router)
    {
        $errors = [];

        $logFormData = [
            "id" => $_GET["id"] ?? null,
            "name" => $_GET["name"] ?? null,
            "student_id" => null
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $logFormData["id"] = $_POST["id"];
            $logFormData["name"] = $_POST["name"];
            $logFormData["student_id"] = $_POST["student_id"];

            $log = new Log();
            $log->load($logFormData);
            $errors = $log->addStudentId();

            if (empty($errors)) {
                header("Location: /log/log_index");
                exit;
            }
        }

        $router->renderView(
            "log/add_student_id",
            [
                "currentPage" => "logIndex",
                "logFormData" => $logFormData,
                "errors" => $errors
            ]
        );
    }

    public function add_time_out(Router $router)
    {
        $logFormData = [
            "id" => $_GET["id"] ?? null,
            "name" => $_GET["name"] ?? null,
            "time_out" => null
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $logFormData["id"] = $_POST["id"];
            $logFormData["time_out"] = date("Y-m-d H:i:s");

            $log = new Log();
            $log->load($logFormData);
            $log->addTimeOut();

            header("Location: /log/log_index");
            exit;
        }

        $router->renderView(
            "log/add_time_out",
            [
                "currentPage" => "logIndex",
            ]
        );
    }

    public function log_edit(Router $router)
    {
        $errors = [];

        $logFormData = [
            "name" => null,
            "student_id" => null,
            "computer_number" => null,
            "time_in" => null,
            "time_out" => null
        ];

        // Getting the existing log from our database
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $logFormData["id"] = $_GET["id"];

            $log = new Log();
            $log->load($logFormData);
            $logFormData = $log->getLogDataById();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $logFormData["id"] = $_POST["id"];
            $logFormData["name"] = $_POST["name"];
            $logFormData["student_id"] = $_POST["student_id"];
            $logFormData["computer_number"] = $_POST["computer_number"];
            $logFormData["time_in"] = date("Y/m/d H:i:s", strtotime($_POST["time_in"]) + date("s"));

            // Checks if there is a time-out set, if none, set to null
            $logFormData["time_out"] = !empty($_POST["time_out"])
                ? date("Y/m/d H:i:s", strtotime($_POST["time_out"]) + date("s"))
                : null;

            // echo "<pre>";
            // var_dump($logFormData);
            // echo "</pre>";
            // exit;

            $log = new Log();
            $log->load($logFormData);
            $errors = $log->updateLogDataById();

            if (empty($errors)) {
                header("Location: /log/log_index");
            }
        }

        $router->renderView(
            "log/log_edit",
            [
                "currentPage" => "logIndex",
                "logFormData" => $logFormData,
                "errors" => $errors
            ]
        );
    }

    public function log_delete(Router $router)
    {
        $logData = [
            "id" => null,
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $logData["id"] = $_POST["id"];

            $log = new Log();
            $log->load($logData);
            $log->deleteLogDataById();

            header("Location: /log/log_index");
        }
    }
}
