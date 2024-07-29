<?php

declare(strict_types=1);

namespace app\controllers\traits;

use app\Router;
use app\models\Admin;

trait AdminCurrentAccount
{
    /**
     * Loads admin_account page containing account information
     * @param \app\Router $router
     * @return void
     */
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
}
