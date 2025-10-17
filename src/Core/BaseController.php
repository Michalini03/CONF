<?php
require_once __DIR__ . '/DatabaseConnector.php';

class BaseController {
    protected $db;

    public function __construct() {
        // Initialize database connection
        $this->db = DatabaseConnector::get();
        $this->db->set_charset("utf8mb4");

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Render a PHP view file and pass data to it
     * @param string $view  Relative path to view file
     * @param array $data   Associative array of data for the view
     */
    protected function render($view, $data = []) {
        // Extract data array to variables
        extract($data);
        // Include the view file
        require __DIR__ . "/../views/{$view}.php";
    }

    /**
     * Redirect to another page
     * @param string $url
     */
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    /**
     * Send JSON response
     * @param array $data
     */
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get logged in user ID
     */
    protected function userId() {
        return $_SESSION['user_id'] ?? null;
    }
}
