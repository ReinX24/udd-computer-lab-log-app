<?php

declare(strict_types=1);

namespace app\controllers;

use app\Router;
use app\models\Feedback;

class FeedbackController
{
    /**
     * Load the index page of the feedback.
     */
    public function index(Router $router)
    {
        $router->renderView(
            "feedback/index",
            ["currentPage" => "index"]
        );
    }

    /**
     * Load the feedback_create page and create a Feedback object.
     */
    public function feedback_create(Router $router)
    {
        $errors = [];
        $feedbackData = [
            "name" => "",
            "feedback" => "",
            "category" => ""
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $feedbackData["name"] = $_POST["name"];
            $feedbackData["feedback"] = $_POST["feedbackText"];
            $feedbackData["category"] = $_POST["categorySelect"];

            $feedback = new Feedback();
            $feedback->load($feedbackData);
            $errors = $feedback->save();

            if (empty($errors)) {
                // If there are no errors, go back to the /feedback/create page
                header("Location: /feedback/create?added_feedback=true");
                exit;
            }
        }

        // If the request is a GET method, also returns errors and feedbackData
        $router->renderView(
            "feedback/feedback_create",
            [
                "currentPage" => "feedbackForm",
                "feedback" => $feedbackData,
                "errors" => $errors
            ]
        );
    }
}
