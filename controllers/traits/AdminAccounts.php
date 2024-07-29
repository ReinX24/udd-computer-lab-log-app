<?php

declare(strict_types=1);

namespace app\controllers\traits;

use app\Router;
use app\models\Admin;

trait AdminAccounts
{
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

    /**
     * Editing an admin account, can only be used for master accounts
     * @param \app\Router $router
     * @return void
     */
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

    /**
     * Deleting an admin account as a master account
     * @param \app\Router $router
     * @return void
     */
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
}
