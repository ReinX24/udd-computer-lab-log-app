<?php

declare(strict_types=1);

namespace app;

use app\models\Feedback;
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
            "mysql:host=localhost;port=3306;dbname=feedback_app",
            "root",
            ""
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

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


    //* START OF FEEDBACK DATABASE FUNCTIONS
    public function getFeedback()
    {
        $getAllFeedback =
            "SELECT
                *
            FROM
                feedback
            ORDER BY
                created_at
            DESC";

        $statement = $this->pdo->prepare($getAllFeedback);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeedbackById(int $feedbackId)
    {
        $getFeedback =
            "SELECT
                *
            FROM
                feedback
            WHERE
                id = :id";

        $statement = $this->pdo->prepare($getFeedback);

        $statement->bindValue(":id", $feedbackId);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getTextMatchFeedback(string $matchString)
    {
        $textMatch =
            "SELECT
                *
            FROM
                feedback
            WHERE
                feedback
            LIKE
                :feedback_text
            ORDER BY
                created_at
            DESC";

        $statement = $this->pdo->prepare($textMatch);

        $statement->bindValue(":feedback_text", "%$matchString%");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthAndYearMatchFeedback(string $monthYearString)
    {
        $dateMatch =
            "SELECT
                *
            FROM
                feedback
            WHERE
                YEAR(created_at) = :yearMatch
            AND
                MONTH(created_at) = :monthMatch
            ORDER BY
                created_at
            DESC";

        $monthMatch = date("m", strtotime($monthYearString));
        $yearMatch = date("Y", strtotime($monthYearString));

        $statement = $this->pdo->prepare($dateMatch);

        $statement->bindValue(":yearMatch", $yearMatch);
        $statement->bindValue(":monthMatch", $monthMatch);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDateFeedback(string $dateString)
    {
        $getDate =
            "SELECT
                *
            FROM
                feedback
            WHERE
                YEAR(created_at) = :yearMatch
            AND
                MONTH(created_at) = :monthMatch
            AND
                DAY(created_at) = :dayMatch";

        $yearMatch = date("Y", strtotime($dateString));
        $monthMatch = date("m", strtotime($dateString));
        $dayMatch = date("d", strtotime($dateString));

        $statement = $this->pdo->prepare($getDate);

        $statement->bindValue(":yearMatch", $yearMatch);
        $statement->bindValue(":monthMatch", $monthMatch);
        $statement->bindValue(":dayMatch", $dayMatch);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeedbackByCategory(string $category)
    {
        $getCategory = "SELECT * FROM feedback WHERE category = :category";

        $statement = $this->pdo->prepare($getCategory);

        $statement->bindValue(":category", $category);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createFeedback(Feedback $feedback)
    {
        $createFeedbackQuery =
            "INSERT INTO
                feedback (name, feedback, category)
            VALUES
                (:name, :feedbackText, :category)";

        $statement = $this->pdo->prepare($createFeedbackQuery);

        $statement->bindValue(":name", $feedback->name);
        $statement->bindValue(":feedbackText", $feedback->feedbackText);
        $statement->bindValue(":category", $feedback->category);

        $statement->execute();
    }

    public function editFeedback(Feedback $feedback)
    {
        $updateFeedbackQuery =
            "UPDATE
                feedback
            SET
                name = :name,
                feedback = :feedback,
                category = :category,
                is_edited = :is_edited
            WHERE
                id = :id";

        $statement = $this->pdo->prepare($updateFeedbackQuery);

        $statement->bindValue(":name", $feedback->name);
        $statement->bindValue(":feedback", $feedback->feedbackText);
        $statement->bindValue(":category", $feedback->category);

        $statement->bindValue(":is_edited", true);

        $statement->bindValue(":id", $feedback->id);

        $statement->execute();
    }

    public function deleteFeedback(Feedback $feedback)
    {
        $deleteFeedbackQuery = "DELETE FROM feedback WHERE id = :id";

        $statement = $this->pdo->prepare($deleteFeedbackQuery);

        $statement->bindValue(":id", $feedback->id);

        $statement->execute();
    }
    //* END OF FEEDBACK DATABASE FUNCTIONS

}
