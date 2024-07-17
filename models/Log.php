<?php

declare(strict_types=1);

namespace app\models;

use app\Database;

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

        // Checks if the student_id is valid
        $errors = $this->validateStudentId($errors);

        if (empty($errors)) {
            // Save data to database
            $this->db->addTimeInLog($this);
        }

        return $errors;
    }

    public function addStudentId()
    {
        $errors = [];

        if (!$this->student_id) {
            $errors["noStudentIdError"] = "Student ID is required.";
        }

        $errors = $this->validateStudentId($errors);

        if (empty($errors)) {
            $this->db->addStudentId($this);
        }

        return $errors;
    }

    public function addTimeOut()
    {
        $this->db->addTimeOutLog($this);
    }

    public function updateLogDataById()
    {
        $errors = [];

        if (!$this->name) {
            $errors["noNameError"] = "Name is required.";
        }

        if (!$this->computer_number) {
            $errors["noComputerNumberError"] = "Computer number is required.";
        }

        // If the time_out is not empty, validate
        if ($this->time_in && $this->time_out) {
            if ($this->time_in >= $this->time_out) {
                $errors["invalidTimeInError"] = "Invalid time-in, must be less than time-out.";
            }
            if ($this->time_out <= $this->time_in) {
                $errors["invalidTimeOutError"] = "Invalid time-out, must be greater than than time-in.";
            }
        }

        if (empty($errors)) {
            $this->db->updateLogDataById($this);
        }

        return $errors;
    }

    public function deleteLogDataById()
    {
        $this->db->deleteLogDataById($this);
    }

    public function getCurrentDayLogs($currentDate)
    {
        return $this->db->getCurrentDayLogs($currentDate);
    }

    public function getLogDataById()
    {
        return $this->db->getLogDataById($this);
    }

    public function getLogsByName()
    {
        return $this->db->getLogsByName($this);
    }

    public function getLogsByStudentId()
    {
        return $this->db->getLogsByStudentId($this);
    }

    public function getLogsByMonthYearTimeIn()
    {
        return $this->db->getLogsByMonthYearTimeIn($this);
    }

    public function getAllLogs()
    {
        return $this->db->getAllLogs();
    }

    // Helper methods
    private function validateStudentId(array $errors): array
    {
        // TODO: check if this validation works properly
        if (!empty($this->student_id)) {
            // Check if the length is 11 (22-0365-456, 11 chars with -)
            if (strlen($this->student_id) !== 11) {
                $errors["invalidStudentIdError"] = "Invalid Student ID input.";
            }

            // This should return the array with 3 values
            $id_values = explode("-", $this->student_id);

            // Checks if there are 3 items in the array
            if (count($id_values) !== 3) {
                $errors["invalidStudentIdError"] = "Invalid Student ID input.";
            }

            // Checks if the values in the array are all digits
            foreach ($id_values as $value) {
                // Checks if the string is not numeric
                if (!preg_match('{^[0-9]*$}', $value)) {
                    $errors["invalidStudentIdError"] = "Invalid Student ID input.";
                }
            }

            // Checks if there are 3 items and each item has the correct number
            // of digits.
            if (
                count($id_values) == 3
                && strlen($id_values[0]) !== 2
                && strlen($id_values[1]) !== 4
                && strlen($id_values[2]) !== 3
            ) {
                $errors["invalidStudentIdError"] = "Invalid Student ID input.";
            }
        }

        return $errors;
    }
}
