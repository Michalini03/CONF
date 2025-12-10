<?php
require_once __DIR__ . '/DatabaseConnector.php';

class BaseController {
    protected $db;

    public function __construct() {
        // Initialize database connection
        $this->db = DatabaseConnector::get();
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Render a PHP view file and pass data to it
     * @param string $component  Component name
     * @param string $view  Relative path to view file
     * @param array $data   Associative array of data for the view
     */
    protected function render($component, $view, $data = []) {
        // Extract data array to variables
        extract($data);
        require __DIR__ . "/../Components/" . $component ."/view/{$view}.php";
    }
}
