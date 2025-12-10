<?php

class DatabaseConnector {
    private static $instance = null;

    // The constructor is private to prevent direct creation
    private function __construct() {}

    /**
     * Get the single PDO database connection instance.
     */
    public static function get() {
        if (self::$instance === null) {

            $host = "db";
            $db   = "conferention_db";   
            $user = "malikm";            
            $pass = "test";              
            $charset = "utf8mb4";

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            $options = [
                // Throw exceptions on errors (stops script, shows what's wrong)
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // Fetch results as associative arrays (e.g., $row['name'])
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Use real prepared statements for better security
                PDO::ATTR_EMULATE_PREPARES   => false,
                // Set the character set
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];

            try {
                 self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                 // Handle connection error
                 http_response_code(500);
                 die("Connection failed: " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }
}