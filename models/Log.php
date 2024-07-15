<?php

declare(strict_types=1);

namespace app\models;

use app\Database;
use DateTime;

class Log
{
    public ?int $id;
    public ?string $name;
    public ?string $student_id;
    public ?int $computer_number;

    public ?string $time_in;
    public ?string $time_out;
    public ?string $created_at;

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function load(array $logData)
    {
        $this->id = array_key_exists("id", $logData)
            ? (int) $logData["id"]
            : null;
        $this->name = $logData["name"] ?? null;
        $this->student_id = $logData["student_id"] ?? null;
        $this->computer_number = array_key_exists("computer_number", $logData)
            ? (int) $logData["computer_number"]
            : null;
        $this->time_in = $logData["time_in"] ?? null;
        $this->time_out = $logData["time_out"] ?? null;
    }

    public function save()
    {
        $errors = [];

        if (!$this->name) {
            $errors["noNameError"] = "Name is required.";
        }

        if (!$this->computer_number) {
            $errors["noComputerNumberError"] = "Computer number is required.";
        }

        if (!$this->time_in) {
            $errors["noTimeInError"] = "Time in is required.";
        }

        if (empty($errors)) {
            // Save data to database
            $this->db->addTimeInLog($this);
        }

        return $errors;
    }

    public function add_student_id()
    {
        $errors = [];

        if (!$this->student_id) {
            $errors["noStudentIdError"] = "Student ID is required.";
        }

        // TODO: verify if the student ID is valid
        echo $this->student_id;
        exit;

        return $errors;
    }

    public function getCurrentDayLogs($currentDate)
    {
        return $this->db->getCurrentDayLogs($currentDate);
    }
}
