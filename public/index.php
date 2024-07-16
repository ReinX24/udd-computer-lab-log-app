<?php

// Using composer to autoload classes
require_once __DIR__ . "/../vendor/autoload.php";

use app\Router;
// use app\controllers\FeedbackController;
use app\controllers\AdminController;
use app\controllers\LogController;

$router = new Router();

$router->addGetRoute("/", [LogController::class, "index"]);

$router->addGetRoute("/log/log_index", [LogController::class, "log_index"]);

$router->addGetRoute("/log/log_add", [LogController::class, "log_add"]);
$router->addPostRoute("/log/log_add", [LogController::class, "log_add"]);

$router->addGetRoute("/log/log_edit", [LogController::class, "log_edit"]);
$router->addPostRoute("/log/log_edit", [LogController::class, "log_edit"]);

// Only a POST route needed, deleted through a modal confirmation
$router->addPostRoute("/log/log_delete", [LogController::class, "log_delete"]);

$router->addGetRoute("/log/add_student_id", [LogController::class, "add_student_id"]);
$router->addPostRoute("/log/add_student_id", [LogController::class, "add_student_id"]);

$router->addGetRoute("/log/add_time_out", [LogController::class, "add_time_out"]);
$router->addPostRoute("/log/add_time_out", [LogController::class, "add_time_out"]);

$router->addGetRoute("/log/admin_login", [AdminController::class, "admin_login"]);
$router->addPostRoute("/log/admin_login", [AdminController::class, "admin_login"]);

$router->addGetRoute("/admin/dashboard", [AdminController::class, "admin_dashboard"]);

$router->addGetRoute("/admin/search", [AdminController::class, "admin_search"]);

$router->addGetRoute("/admin/search/details", [AdminController::class, "admin_search_details"]);

// Only master accounts can edit searches
$router->addGetRoute("/admin/search/edit", [AdminController::class, "admin_search_edit"]);
$router->addPostRoute("/admin/search/edit", [AdminController::class, "admin_search_edit"]);

// Only master accounts can delete searches
$router->addGetRoute("/admin/search/delete", [AdminController::class, "admin_search_delete"]);
$router->addPostRoute("/admin/search/delete", [AdminController::class, "admin_search_delete"]);

// View all existing accounts
$router->addGetRoute("/admin/accounts", [AdminController::class, "admin_accounts"]);

// View currently logged in account details
$router->addGetRoute("/admin/account", [AdminController::class, "admin_account"]);

// Editing the currently logged in account
$router->addGetRoute("/admin/account/edit_account", [AdminController::class, "admin_current_edit"]);
$router->addPostRoute("/admin/account/edit_account", [AdminController::class, "admin_current_edit"]);

// Deleting the current account of the logged in account
$router->addGetRoute("/admin/account/delete_account", [AdminController::class, "admin_current_delete"]);
$router->addPostRoute("/admin/account/delete_account", [AdminController::class, "admin_current_delete"]);

// Master accounts can add accounts
$router->addGetRoute("/admin/accounts/add", [AdminController::class, "admin_add"]);
$router->addPostRoute("/admin/accounts/add", [AdminController::class, "admin_add"]);

// Master accounts can delete accounts
$router->addGetRoute("/admin/accounts/delete", [AdminController::class, "admin_delete"]);
$router->addPostRoute("/admin/accounts/delete", [AdminController::class, "admin_delete"]);

// Master accounts can edit accounts, can change username, password, and privileges
$router->addGetRoute("/admin/accounts/edit", [AdminController::class, "admin_edit"]);
$router->addPostRoute("/admin/accounts/edit", [AdminController::class, "admin_edit"]);

$router->addGetRoute("/admin/logout", [AdminController::class, "admin_logout"]);
$router->addPostRoute("/admin/logout", [AdminController::class, "admin_logout"]);

// The router will resolve the URL and find the corresponding controller and method
$router->resolve();
