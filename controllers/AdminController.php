<?php

declare(strict_types=1);

namespace app\controllers;

use app\Router;
use app\models\Admin;
use app\models\Log;
use \DateTime;

class AdminController
{
    public function admin_login(Router $router)
    {
        $errors = [];
        $adminLoginData = [
            "username" => "",
            "password" => "",
            "passwordRepeat" => ""
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $adminLoginData["username"] = $_POST["name"];
            $adminLoginData["password"] = $_POST["password"];
            $adminLoginData["passwordRepeat"] = $_POST["passwordRepeat"];

            $admin = new Admin();
            $admin->load($adminLoginData);
            $errors = $admin->login();

            if (empty($errors)) {
                header("Location: /admin/dashboard");
                exit;
            }
        }

        $router->renderView(
            "log/admin_login",
            [
                "currentPage" => "adminLoginForm",
                "adminLoginData" => $adminLoginData,
                "errors" => $errors
            ]
        );
    }

    public function admin_dashboard(Router $router)
    {
        $this->check_logged_in();

        $router->renderView(
            "admin/admin_dashboard",
            [
                "currentPage" => "adminIndex",
            ]
        );
    }

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

    public function admin_accounts(Router $router)
    {
        $this->check_logged_in();

        $admin = new Admin();
        $adminData = $admin->getAdminAccounts();

        $router->renderView(
            "admin/admin_accounts",
            [
                "currentPage" => "adminAccounts",
                "adminData" => $adminData
            ]
        );
    }

    // Adding an admin account, can only be used for master accounts
    public function admin_add(Router $router)
    {
        $this->check_master_logged_in();

        $errors = [];

        $adminData = [
            "username" => "",
            "password" => "",
            "passwordReapeat" => "",
            "master_account" => false
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $adminData["username"] = $_POST["username"];
            $adminData["password"] = $_POST["password"];
            $adminData["passwordRepeat"] = $_POST["passwordRepeat"];
            $adminData["master_account"] = isset($_POST["masterAccount"]);

            $admin = new Admin();

            $admin->load($adminData);
            $errors = $admin->addAdmin();

            if (empty($errors)) {
                header("Location: /admin/accounts?account_success_add=true");
                exit;
            }
        }

        $router->renderView(
            "admin/admin_add",
            [
                "currentPage" => "adminAccounts",
                "adminData" => $adminData,
                "errors" => $errors
            ]
        );
    }

    // Editing an admin account, can only be used for master accounts
    public function admin_edit(Router $router)
    {
        $this->check_master_logged_in();

        $errors = [];

        $adminData = [
            "id" => "",
            "username" => "",
            "password" => "",
            "changePassword" => false,
            "passwordNew" => "",
            "passwordNewRepeat" => "",
            "master_account" => null
        ];

        $admin = new Admin();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Get id from GET request and get account
            $id = (int) $_GET["id"];
            $adminData = $admin->getAdminAccountById($id);

            // Change password will be set to false
            $adminData["changePassword"] = false;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $adminData["id"] = (int) $_POST["id"];
            $adminData["username"] = $_POST["username"];
            // The password loaded is the password for the currently logged in account
            $adminData["password"] = $_POST["password"];
            $adminData["changePassword"] = isset($_POST["changePassword"]);
            $adminData["passwordNew"] = $_POST["passwordNew"];
            $adminData["passwordNewRepeat"] = $_POST["passwordNewRepeat"];
            $adminData["master_account"] = isset($_POST["master_account"]);

            $admin->load($adminData);
            $errors = $admin->editAdmin();

            if (empty($errors)) {
                // If we apply edits to current account, logout account
                if ($admin->id == $_SESSION["userLoginInfo"]["id"]) {
                    $this->admin_logout($router);
                }
                // If the edited account is not the current account
                header("Location: /admin/accounts?account_success_edit=true");
                exit;
            }
        }

        $router->renderView(
            "admin/admin_edit",
            [
                "currentPage" => "adminAccounts",
                "adminData" => $adminData,
                "errors" => $errors
            ]
        );
    }

    // Deleting an admin account as a master account
    public function admin_delete(Router $router)
    {
        $this->check_master_logged_in();

        $errors = [];

        $adminData = [
            "id" => ""
        ];

        $admin = new Admin();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $id = (int) $_GET["id"];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = (int) $_POST["id"];
            $adminData["id"] = $id;

            $admin->load($adminData);
            $errors = $admin->deleteAdmin();

            if (empty($errors)) {
                // If the current user is the one being deleted, return to index
                if ($_SESSION["userLoginInfo"]["id"] == $_POST["id"]) {
                    $this->admin_logout($router);
                }

                // Go to the accounts page with success message
                header("Location: /admin/accounts?account_success_delete=true");
            }
        }

        // Get the admin account info by their id
        $adminData = $admin->getAdminAccountById($id);

        $router->renderView(
            "admin/admin_delete",
            [
                "currentPage" => "adminAccounts",
                "adminData" => $adminData,
                "errors" => $errors
            ]
        );
    }

    // Current admin account credentials page
    public function admin_account(Router $router)
    {
        $this->check_logged_in();

        $router->renderView(
            "admin/admin_account",
            [
                "currentPage" => "adminAccount",
            ]
        );
    }

    // Edit the currently logged in admin account
    public function admin_current_edit(Router $router)
    {
        $this->check_logged_in();

        $errors = [];

        $adminData = [
            "id" => "",
            "username" => "",
            "password" => "",
            "changePassword" => false,
            "passwordNew" => "",
            "passwordNewRepeat" => "",
            "master_account" => ""
        ];

        $admin = new Admin();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $adminData = $_SESSION["userLoginInfo"];
            $adminData["changePassword"] = false;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $adminData["id"] = $_SESSION["userLoginInfo"]["id"];
            $adminData["username"] = $_POST["username"];
            $adminData["password"] = $_POST["password"];
            $adminData["changePassword"] = isset($_POST["changePassword"]);
            $adminData["passwordNew"] = $_POST["passwordNew"];
            $adminData["passwordNewRepeat"] = $_POST["passwordNewRepeat"];

            // master_account status cannot be changed
            $adminData["master_account"] = $_SESSION["userLoginInfo"]["master_account"] ? true : false;

            $admin->load($adminData);
            $errors = $admin->editAdmin();

            if (empty($errors)) {
                // If there are no errors, logout the current account
                $this->admin_logout($router);
            }
        }

        $router->renderView(
            "admin/admin_current_edit",
            [
                "currentPage" => "adminAccount",
                "adminData" => $adminData,
                "errors" => $errors
            ]
        );
    }

    public function admin_current_delete(Router $router)
    {
        $this->check_logged_in();

        $errors = [];

        $adminData = [
            "id" => "",
        ];

        $admin = new Admin();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $adminData["id"] = $_SESSION["userLoginInfo"]["id"];

            $admin->load($adminData);
            $errors = $admin->deleteAdmin();

            if (empty($errors)) {
                // After deleting the current account, logout and go back to index
                $this->admin_logout($router);
            }
        }

        $router->renderView(
            "admin/admin_current_delete",
            [
                "currentPage" => "adminAccount",
                "errors" => $errors
            ]
        );
    }

    public function admin_logout(Router $router)
    {
        $this->check_logged_in();

        // Destroy all session variables and return to index page
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            session_start();

            session_unset();
            session_destroy();

            header("Location: /");
            exit;
        }

        $router->renderView("admin/admin_logout");
    }

    // Starts the session and checks if the user is logged in
    public function check_logged_in()
    {
        session_start();

        if (!$_SESSION["isLoggedIn"]) {
            header("Location: /");
            exit;
        }
    }

    // Checks if the current logged in account is a master account
    public function check_master_logged_in()
    {
        $this->check_logged_in();

        if (!$_SESSION["userLoginInfo"]["master_account"]) {
            header("Location: /admin/dashboard");
        }
    }
}
