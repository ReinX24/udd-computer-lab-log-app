<?php

declare(strict_types=1);

namespace app\controllers;

use app\Router;
use app\models\Log;

use DateTime;

/**
 * Class for redirecting the user in the udd-computer-lab-log-app
 */
class LogController
{
    private Log $logData;

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
}
