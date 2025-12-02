<?php
class LoginModel {

    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get a user's ID from their username.
     */
    public function getUserId($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(); // Gets one row

        if ($row) {
            return $row['id'];
        } else {
            return -1; // No user found
        }
    }

    /**
     * Validate a user's password.
     * On success, returns the user's data (row).
     * On failure (bad ID or bad password), returns false.
     */
    public function validateUser($id, $password) {
        // FIXED: Uses prepared statements to prevent SQL injection
        // FIXED: Uses $this->db, not a new connection
        $stmt = $this->db->prepare("SELECT password, access_rights FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) {
            return false; // User does not exist
        }

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct! Return the user data.
            // The CONTROLLER will be responsible for setting the session.
            return $row; 
        } else {
            // Password is wrong
            return false;
        }
    }


    /**
     * Create a new user.
     */
    public function createUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $accessLevel = 1; 

        $sql = "INSERT INTO users (username, password, access_rights) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        // Pass parameters in the execute array
        if ($stmt->execute([$username, $hashedPassword, $accessLevel])) {
            return $this->db->lastInsertId(); // Use PDO's method
        } else {
            return -1;
        }
    }
}