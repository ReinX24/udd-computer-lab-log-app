<?php

declare(strict_types=1);

namespace app\controllers;

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
        $router->renderView(
            "log/log_index",
            ["currentPage" => "logIndex"]
        );
    }
}
