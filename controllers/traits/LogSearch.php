<?php

declare(strict_types=1);

namespace app\controllers\traits;

use app\Router;
use app\models\Log;
use \DateTime;

trait LogSearch
{

    // Start search log
    public function admin_search_log(Router $router)
    {
        $this->check_logged_in();

        $errors = [];

        $logData = [
            "name" => null,
            "student_id" => null,
            "computer_number" => null,
            "time_in" => null,
            "time_out" => null,
        ];

        $log = new Log();
        $matchedLogs = $log->getAllLogs();

        if (isset($_GET["search_name"]) && !empty($_GET["search_name"])) {
            $logData["name"] = $_GET["search_name"];
            $log->load($logData);
            $matchedLogs = $log->getLogsByName();
        }

        if (isset($_GET["search_student_id"]) && !empty($_GET["search_student_id"])) {
            // TODO: check if the student_id is a valid id
            $logData["student_id"] = $_GET["search_student_id"];
            $log->load($logData);

            // Check for any errors
            $errors = $log->validateStudentId($errors);

            // If there are errors, set matchedLogs to null
            if (!empty($errors)) {
                $matchedLogs = null;
            } else {
                $matchedLogs = $log->getLogsByStudentId();
            }
        }

        if (isset($_GET["search_month_and_year"]) && !empty($_GET["search_month_and_year"])) {
            $logData["time_in"] = $_GET["search_month_and_year"];
            $log->load($logData);
            $matchedLogs = $log->getLogsByMonthYearTimeIn();
        }

        if (isset($_GET["search_date"]) && !empty($_GET["search_date"])) {
            $logData["time_in"] = $_GET["search_date"];
            $log->load($logData);
            $matchedLogs = $log->getLogsByDateTimeIn();
        }

        // Getting the current dates for placeholders
        $currentDate = new DateTime();
        $currentYearMonth = $currentDate->format("Y-m");
        $currentDayMonthYear = $currentDate->format("Y-m-d");

        $router->renderView(
            "admin/admin_search_log",
            [
                "currentPage" => "adminSearchLog",
                "currentYearMonth" => $currentYearMonth,
                "currentDayMonthYear" => $currentDayMonthYear,
                "matchedLogs" => $matchedLogs,
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
                header("Location: /admin/search_log?add_student_id_success=true");
                exit;
            }
        }

        $router->renderView(
            "admin/add_student_id",
            [
                "currentPage" => "adminSearchLog",
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

            header("Location: /admin/search_log?time_out_success=true");
            exit;
        }

        $router->renderView(
            "admin/add_time_out",
            [
                "currentPage" => "adminSearchLog",
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

            $log = new Log();
            $log->load($logFormData);
            $errors = $log->updateLogDataById();

            if (empty($errors)) {
                header("Location: /admin/search_log?edit_success=true");
            }
        }

        $router->renderView(
            "admin/log_edit",
            [
                "currentPage" => "adminSearchLog",
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

            header("Location: /admin/search_log?delete_sucesss=true");
        }
    }
    // End search log
}
