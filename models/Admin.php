<?php

declare(strict_types=1);

namespace app\models;

use app\Database;

class Admin
{
    public ?int $id;
    public ?string $username;

    public ?string $password;
    public ?string $passwordRepeat;

    public ?bool $changePassword;

    public ?string $passwordNew;
    public ?string $passwordNewRepeat;

    public ?bool $master_account;

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function load(array $adminData)
    {
        $this->id = array_key_exists("id", $adminData) ? (int) $adminData["id"] : null;
        $this->username = $adminData["username"] ?? null;

        $this->password = $adminData["password"] ?? null;
        $this->passwordRepeat = $adminData["passwordRepeat"] ?? null;

        $this->changePassword = $adminData["changePassword"] ?? null;

        // Set new password variables if the user wants to change passwords
        if ($this->changePassword) {
            $this->passwordNew = $adminData["passwordNew"] ?? null;
            $this->passwordNewRepeat = $adminData["passwordNewRepeat"] ?? null;
        }

        $this->master_account = $adminData["master_account"] ?? null;
    }

    public function login()
    {
        $errors = [];

        if (!$this->username) {
            $errors["usernameEmptyError"] = "Username empty!";
        }

        if (!$this->password) {
            $errors["passwordEmptyError"] = "Password empty!";
        }

        if (!$this->passwordRepeat) {
            $errors["passwordRepeatError"] = "Password repeat empty!";
        }

        if (
            !empty($this->password) && !empty($this->passwordRepeat)
            && $this->password !== $this->passwordRepeat
        ) {
            $errors["passwordsMismatchError"] = "Passwords are not the same!";
        }

        // Find the user and get record in database
        $adminCredentials = $this->db->getAdminDataByUsername($this);

        if (empty($adminCredentials)) {
            $errors["userNotFoundError"] = "User not found!";
        }

        if (
            isset($adminCredentials["password"])
            &&
            !password_verify($this->password, $adminCredentials["password"])
        ) {
            $errors["wrongPasswordError"] = "Wrong password!";
        }

        if (empty($errors)) {
            session_start();
            $_SESSION["userLoginInfo"] = $adminCredentials;
            $_SESSION["isLoggedIn"] = true;
        }

        return $errors;
    }

    public function addAdmin()
    {
        $errors = [];

        if (!$this->username) {
            $errors["emptyUsernameError"] = "Username is required.";
        }

        if (!$this->password) {
            $errors["emptyPasswordError"] = "Password is required.";
        }

        if (!$this->passwordRepeat) {
            $errors["emptyPasswordRepeatError"] = "Password repeat is required.";
        }

        if (
            $this->password !== $this->passwordRepeat &&
            !empty($this->password) && !empty($this->passwordRepeat)
        ) {
            $errors["passwordsMismatchError"] = "Passwords do not match.";
        }

        // Checking if the username is already taken, returns false if not
        $matchedCredentials = $this->db->getAdminDataByUsername($this);

        // If there are any matched credentials
        if ($matchedCredentials) {
            $errors["usernameTakenError"] = "Username already taken.";
        }

        if (empty($errors)) {
            $this->db->addAdminAccount($this);
        }

        return $errors;
    }

    /**
     * Edit admin account credentials. Cannot edit master account with an ID of
     * 1 unless the currently logged in account is the master account with an ID
     * of 1. Also cannot remove the master status account of the said account
     * with an ID of 1, regardless of which account us being used.
     * @return string[] errors
     */
    public function editAdmin()
    {
        $errors = [];

        // Check if the username is empty
        if (!$this->username) {
            $errors["emptyUsernameError"] = "Username is required.";
        }

        // Check if the password is empty
        if (!$this->password) {
            $errors["emptyPasswordError"] = "Password is required.";
        }

        // Get an admin account by their username
        $matchedUsername = $this->db->getAdminDataByUsername($this);

        // Check if there is a match and if the id is different from the 
        // currently being edited admin account
        if (!empty($matchedUsername) && $matchedUsername["id"] !== $this->id) {
            $errors["usernameTakenError"] = "Username already taken.";
        }

        // Checks if the password is the same with the currently logged in account
        if (
            $this->password
            && !password_verify(
                $this->password,
                $_SESSION["userLoginInfo"]["password"]
            )
        ) {
            $errors["wrongPasswordError"] = "Wrong password!";
        }

        // If the current admin is not the original master account and they are 
        // trying to edit the original master_account, deny action
        if ($_SESSION["userLoginInfo"]["id"] !== 1 && $this->id == 1) {
            $errors["adminEditDenied"] = "Edit Denied!";
        }

        // If the original master account tries to remove their account 
        // privileges, deny action
        if (
            $_SESSION["userLoginInfo"]["id"] == 1
            && $this->id == 1
            && !$this->master_account
        ) {
            $errors["adminEditDenied"] = "Edit Denied!";
        }

        // If the user decides to change their password, check for errors
        if ($this->changePassword) {
            if (!$this->passwordNew) {
                $errors["emptyPasswordNewError"] = "New password is required.";
            }

            if (!$this->passwordNewRepeat) {
                $errors["emptyPasswordRepeatNewError"] = "Repeat new password is required.";
            }

            // Check if the new passwords are the same
            if (
                $this->passwordNew !== $this->passwordNewRepeat &&
                !empty($this->passwordNew) && !empty($this->passwordNewRepeat)
            ) {
                $errors["passwordsNewMismatchError"] = "New passwords do not match.";
            }
        }

        if (empty($errors)) {
            // Edit the current account and replace login info
            $this->db->editAdminAccount($this);

            // If the current account is the one being edited, apply changes
            if ($_SESSION["userLoginInfo"]["id"] == $this->id) {
                $adminCredentials = $this->db->getAdminDataByUsername($this);
                $_SESSION["userLoginInfo"] = $adminCredentials;
            }
        }

        return $errors;
    }

    /**
     * Cannot delete admin account with an ID of 1. This is to avoid someone
     * being able to delete all the accounts in the database.
     * @return string[] errors
     */
    public function deleteAdmin()
    {
        $errors = [];

        // DONE: make it where the admin account is non deleteable
        // Cannot delete the admin account with an id of 1
        if ($this->id == 1) {
            $errors["adminDeleteDenied"] = "Delete Denied!";
        }

        if (empty($errors)) {
            $this->db->deleteAdminAccount($this);
        }

        return $errors;
    }

    public function getAdminAccounts()
    {
        return $this->db->getAdminAccounts();
    }

    public function getAdminAccountById(int $id)
    {
        return $this->db->getAdminById($id);
    }
}
