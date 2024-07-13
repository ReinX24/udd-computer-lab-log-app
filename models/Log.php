<?php

declare(strict_types=1);

namespace app\models;

use app\Database;
use DateTime;

class Log
{
    public ?int $id;
    public ?string $name;
    public ?string $studentId;

    public ?string $timeIn;
    public ?string $timeOut;
    public ?string $createdDate;

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function load(array $logData)
    {
        $this->id = array_key_exists("id", $logData) ? (int) $logData["id"] : null;
        $this->name = $logData["name"] ?? null;
        $this->studentId = $logData["studentId"] ?? null;
        $this->timeIn = $logData["timeIn"] ?? null;
        $this->timeOut = $logData["timeOut"] ?? null;
    }

    public function save()
    {
        $errors = [];

        if (!$this->name) {
            $errors["noNameError"] = "Name is required.";
        }

        if (!$this->timeIn) {
            $errors["noTimeInError"] = "Time in is required.";
        }

        if (empty($errors)) {
            // Save data to database
        }

        return $errors;
    }

    public function getCurrentDayLogs($currentDate)
    {
        return $this->db->getCurrentDayLogs($currentDate);
    }
}
