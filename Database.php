<?php

declare(strict_types=1);

namespace app;

use app\models\Admin;
use app\models\Log;
use \PDO;

class Database
{
    public PDO $pdo;
    public static Database $db;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=localhost;port=3306;dbname=log_app",
            "root",
            ""
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    //* START OF LOG DATABASE FUNCTIONS
    public function addTimeInLog(Log $logData)
    {
        $addTimeInQuery =
            "INSERT INTO
                lab_log (name, student_id, computer_number, time_in)
            VALUES
                (:name, :student_id, :computer_number, :time_in)";

        $statement = $this->pdo->prepare($addTimeInQuery);

        $statement->bindValue(":name", $logData->name);
        $statement->bindValue(":student_id", $logData->student_id);
        $statement->bindValue(":computer_number", $logData->computer_number);
        $statement->bindValue(":time_in", $logData->time_in);

        $statement->execute();
    }

    public function addTimeOutLog(Log $logData)
    {
        // TODO: check if the time-in is the same as recorded alongside id
        $addTimeOutQuery =
            "UPDATE
                lab_log
            SET
                time_out = :time_out
            WHERE 
                id = :id";

        $statement = $this->pdo->prepare($addTimeOutQuery);

        $statement->bindValue(":time_out", $logData->time_out);
        $statement->bindValue(":id", $logData->id);

        $statement->execute();
    }

    public function addStudentId(Log $logData)
    {
        // TODO: check if the time-in is the same as recorded alongside id
        $addStudentIdQuery =
            "UPDATE
                lab_log
            SET
                student_id = :student_id
            WHERE
                id = :id";

        $statement = $this->pdo->prepare($addStudentIdQuery);

        $statement->bindValue(":student_id", $logData->student_id);
        $statement->bindValue(":id", $logData->id);

        $statement->execute();
    }

    public function updateLogDataById(Log $logData)
    {
        $updateLogQuery =
            "UPDATE
                lab_log
            SET
                name = :name,
                student_id = :student_id,
                computer_number = :computer_number,
                time_in = :time_in,
                time_out = :time_out
            WHERE
                id = :id";

        $statement = $this->pdo->prepare($updateLogQuery);

        $statement->bindValue(":name", $logData->name);
        $statement->bindValue(":student_id", $logData->student_id);
        $statement->bindValue(":computer_number", $logData->computer_number);
        $statement->bindValue(":time_in", $logData->time_in);
        $statement->bindValue(":time_out", $logData->time_out);

        $statement->bindValue(":id", $logData->id);

        $statement->execute();
    }

    public function deleteLogDataById(Log $logData)
    {
        $deleteLogQuery =
            "DELETE FROM
                lab_log
            WHERE
                id = :id";

        $statement = $this->pdo->prepare($deleteLogQuery);

        $statement->bindValue(":id", $logData->id);

        $statement->execute();
    }

    public function getLogDataById(Log $logData)
    {
        $getLogQuery =
            "SELECT
                *
            FROM
                lab_log
            WHERE
                id = :id";

        $statement = $this->pdo->prepare($getLogQuery);

        $statement->bindValue(":id", $logData->id);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getLogsByName(Log $logdata)
    {
        $getByNameQuery =
            "SELECT
                *
            FROM
                lab_log
            WHERE
                name
            LIKE
                :name
            ORDER BY
                created_at
            DESC";

        $statement = $this->pdo->prepare($getByNameQuery);

        $statement->bindValue(":name", "%$logdata->name%");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLogsByStudentId(Log $logData)
    {
        $getByStudentIdQuery =
            "SELECT * FROM lab_log WHERE student_id = :student_id";

        $statement = $this->pdo->prepare($getByStudentIdQuery);

        $statement->bindValue(":student_id", $logData->student_id);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLogsByMonthYearTimeIn(Log $logData)
    {
        $getLogsMonthYearQuery =
            "SELECT
                *
            FROM
                lab_log
            WHERE
                MONTH(time_in) = :month
            AND
                YEAR(time_in) = :year";

        $statement = $this->pdo->prepare($getLogsMonthYearQuery);

        $statement->bindValue(":month", (int) date("m", strtotime($logData->time_in)));
        $statement->bindValue(":year", (int) date("Y", strtotime($logData->time_in)));

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLogsByDateTimeIn(Log $logData)
    {
        $getLogsDateQuery =
            "SELECT
                *
            FROM
                lab_log
            WHERE
                MONTH(time_in) = :month
            AND
                DAY(time_in) = :day
            AND
                YEAR(time_in) = :year";

        $statement = $this->pdo->prepare($getLogsDateQuery);

        $statement->bindValue(":month", (int) date("m", strtotime($logData->time_in)));
        $statement->bindValue(":day", (int) date("d", strtotime($logData->time_in)));
        $statement->bindValue(":year", (int) date("Y", strtotime($logData->time_in)));

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCurrentDayLogs($currentDate)
    {
        $getCurrentDayLogsQuery =
            "SELECT 
                * 
            FROM
                lab_log
            WHERE
                :currentDate = CAST(created_at as DATE)
            ORDER BY
                created_at
            ASC";

        $statement = $this->pdo->prepare($getCurrentDayLogsQuery);

        $statement->bindValue("currentDate", $currentDate);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //* END OF LOG DATABASE FUNCTIONS

    public function getAllLogs()
    {
        $selectAllQuery =
            "SELECT * FROM lab_log ORDER BY created_at DESC";

        $statement = $this->pdo->prepare($selectAllQuery);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //* END OF LOG DATABASE FUNCTIONS

    //* START OF ADMIN DATABASE FUNCTIONS
    public function getAdminDataByUsername(Admin $adminData)
    {
        $getAdminQuery =
            "SELECT
                *
            FROM
                admin_accounts
            WHERE
                username = :username";

        $statement = $this->pdo->prepare($getAdminQuery);

        $statement->bindValue(":username", $adminData->username);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminById(int $id)
    {
        $getAdminByIdQuery = "SELECT * FROM admin_accounts WHERE id = :id";

        $statement = $this->pdo->prepare($getAdminByIdQuery);

        $statement->bindValue(":id", $id);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminAccounts()
    {
        $adminAccountQuery =
            "SELECT
                *
            FROM
                admin_accounts";

        $statement = $this->pdo->prepare($adminAccountQuery);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAdminAccount(Admin $adminData)
    {
        $addAccountQuery =
            "INSERT INTO
                admin_accounts (username, password, master_account)
            VALUES
                (:username, :password, :master_account)";

        $statement = $this->pdo->prepare($addAccountQuery);

        $statement->bindValue(":username", $adminData->username);
        $statement->bindValue(":password", password_hash($adminData->password, PASSWORD_DEFAULT));
        $statement->bindValue(":master_account", $adminData->master_account);

        $statement->execute();
    }

    public function editAdminAccount(Admin $adminData)
    {
        // Set password in query if change password is enabled
        if ($adminData->changePassword) {
            $editAccountQuery =
                "UPDATE 
                    admin_accounts
                SET
                    username = :username,
                    password = :password,
                    master_account = :master_account
                WHERE
                    id = :id";
        } else {
            $editAccountQuery =
                "UPDATE 
                    admin_accounts
                SET
                    username = :username,
                    master_account = :master_account
                WHERE
                    id = :id";
        }

        $statement = $this->pdo->prepare($editAccountQuery);

        $statement->bindValue(":username", $adminData->username);

        // Change password if the user wants to change password
        if ($adminData->changePassword) {
            $statement->bindValue(":password", password_hash($adminData->passwordNew, PASSWORD_DEFAULT));
        }

        $statement->bindValue(":master_account", $adminData->master_account);

        $statement->bindValue(":id", $adminData->id);

        $statement->execute();
    }

    public function deleteAdminAccount(Admin $adminData)
    {
        $deleteAccountQuery = "DELETE FROM admin_accounts WHERE id = :id";

        $statement = $this->pdo->prepare($deleteAccountQuery);

        $statement->bindValue(":id", $adminData->id);

        $statement->execute();
    }
    //* END OF ADMIN DATABASE FUNCTIONS
}
