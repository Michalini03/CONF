<?php

class DatabaseConnector {
    private static $instance = null;
    
    // Create a connection to the database
    public static function get() {
        if (self::$instance === null) {
            self::$instance = new mysqli("localhost", "root", "", "conferention_db");
        }
        return self::$instance;
    }
}