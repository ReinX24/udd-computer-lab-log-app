<?php

declare(strict_types=1);

namespace app\models;

use app\Database;

class Feedback
{
    public ?int $id;
    public ?string $name;
    public ?string $feedbackText;
    public ?string $category;
    private Database $db;

    /**
     * Feedback object constructor, instantiate a database object.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Load Feedback object data, loads id, name, and category.
     */
    public function load(array $feedbackData)
    {
        $this->id = array_key_exists("id", $feedbackData) ? (int) $feedbackData["id"] : null;
        $this->name = $feedbackData["name"] ?? null;
        $this->category = $feedbackData["category"] ?? null;

        // If the name is empty, set name as "Anonymous"
        if (empty($this->name)) {
            $this->name = "Anonymous";
        }

        $this->feedbackText = $feedbackData["feedback"] ?? null; // required
    }

    /**
     * Save the feedback to the database, return errors if there are any.
     */
    public function save()
    {
        $errors = [];

        if (!$this->feedbackText) {
            $errors["feedbackTextError"] = "Feedback is required!";
        }

        if (empty($errors)) {
            $this->db->createFeedback($this);
        }

        return $errors;
    }

    /**
     * Edit or update the feedback in the database, return errors if there are any.
     */
    public function edit()
    {
        $errors = [];

        if (!$this->feedbackText) {
            $errors["feedbackTextError"] = "Feedback is required!";
        }

        if (empty($errors)) {
            $this->db->editFeedback($this);
        }

        return $errors;
    }

    /**
     * Delete feedback from the database.
     */
    public function delete()
    {
        $this->db->deleteFeedback($this);
    }

    /**
     * Get all the feedback from the database.
     */
    public function getAllFeedback()
    {
        return $this->db->getFeedback();
    }

    /**
     * Get feedback from database with matching text.
     */
    public function getFeedbackByText(string $searchText)
    {
        return $this->db->getTextMatchFeedback($searchText);
    }

    /**
     * Get feedback by their month and year.
     */
    public function getFeedbackByMonthAndYear(string $monthYearString)
    {
        return $this->db->getMonthAndYearMatchFeedback($monthYearString);
    }

    /**
     * Get feedback by their date (day, month, and year).
     */
    public function getFeedbackByExactDate(string $date)
    {
        return $this->db->getDateFeedback($date);
    }

    /**
     * Get feedback by their category.
     */
    public function getFeedbackByCategory(string $category)
    {
        // If the user chooses "all", return all the feedback
        if ($category == "all") {
            return $this->db->getFeedback();
        }

        return $this->db->getFeedbackByCategory($category);
    }

    /**
     * Get feedback by their id.
     */
    public function getFeedbackById(int $feedbackId)
    {
        return $this->db->getFeedbackById($feedbackId);
    }
}
