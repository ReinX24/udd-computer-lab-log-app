<?php

declare(strict_types=1);

namespace app;

use app\Database;

class Router
{
    // GET and POST routes
    public array $getRoutes = [];
    public array $postRoutes = [];

    // public Database $db;

    /**
     * Router constructor, instantiates database for GET and POST requests.
     */
    // public function __construct()
    // {
    // $this->db = new Database(); // instantiating database object
    // }

    /**
     * Adds a GET route, the url (key) will store the controller and method.
     */
    public function addGetRoute(string $url, array $fn)
    {
        $this->getRoutes[$url] = ["controller" => $fn[0], "method" => $fn[1]];
    }

    /**
     * Add a POST route, the url (key) will store the controller and method.
     */
    public function addPostRoute(string $url, array $fn)
    {
        $this->postRoutes[$url] = ["controller" => $fn[0], "method" => $fn[1]];
    }

    /**
     * Getting the current REQUEST_URI and resolving to database.
     */
    public function resolve()
    {
        // Gettign the REQUEST_URI
        $currentUrl = $_SERVER["REQUEST_URI"] ?? "/";

        // Removing the query string from the url
        if (strpos($currentUrl, "?")) {
            $currentUrl = substr($currentUrl, 0, strpos($currentUrl, "?"));
        }

        // Checking if the request is a GET or POST request
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        // Finding the corresponding GET or POST controller and method
        if ($requestMethod == "GET") {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        // Checks if the controller and method exists
        if ($fn) {
            // Create a controller for the class
            $controlller = new $fn["controller"]();
            // Get the method
            $method = $fn["method"];
            // Execute the method that is inside the controller
            $controlller->$method($this);
        } else {
            // If the controller and method does not exist
            echo "Page not found";
        }
    }

    /**
     * Rendering the view requested by our controller.
     */
    public function renderView($view, $params = [])
    {
        // Converts key value array items into variables and values
        extract($params);

        // Starts buffering, loads the entire page before being sent to browser
        ob_start();

        // This include is stored for buffering, not yet loaded
        include_once __DIR__ . "/views/{$view}.php";

        // Get the contents inside the buffer
        $content = ob_get_clean();

        // Include _layout.php, this also loads the $content which stores the view
        include_once __DIR__ . "/views/_layout.php";
    }
}
