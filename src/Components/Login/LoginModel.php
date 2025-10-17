<?php
class LoginModel {

      private $db;
      public function __construct($db) {
            $this->db = $db;
      }

      public function getUserId($username) {
            
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if a user was found
            if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  return $row['id'];
            } else {
                  return -1;
            }
      }


      public function validateUser($id, $password) {
            $db = DatabaseConnector::get();
            $result = $db->query("SELECT password FROM users WHERE id = '$id'");

            if ($result->num_rows === 0) {
            return false; // User does not exist
            }

            $row = $result->fetch_assoc();
            return password_verify($password, $row['password']);
      }
}