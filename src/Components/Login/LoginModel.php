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
            $result = $db->query("SELECT password, access_rights FROM users WHERE id = '$id'");

            if ($result->num_rows === 0) {
                  return false; // User does not exist
            }

            $row = $result->fetch_assoc();
            $_SESSION['access_rights'] = $row['access_rights'];
            return password_verify($password, $row['password']);
      }


      public function createUser($username, $password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $accessLevel = 0; // must be a variable

            $stmt = $this->db->prepare("INSERT INTO users (username, password, access_rights) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $username, $hashedPassword, $accessLevel);


            if ($stmt->execute()) {
                  return $this->db->insert_id;
            } else {
                  return -1;
            }
      }
}