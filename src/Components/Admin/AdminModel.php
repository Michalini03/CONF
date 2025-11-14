<?php

class AdminModel {
      private $db;

      public function __construct($dbConnection) {
            $this->db = $dbConnection;
      }

      /**
       * Get all standard users.
       */
      public function getAllUsers() {
            $stmt = $this->db->prepare("SELECT id, username, access_rights FROM users WHERE access_rights < 2");
            $stmt->execute();
            return $stmt->fetchAll(); // Uses the default FETCH_ASSOC from your connector
      }

      /**
       * Get all admin/editor users.
       */
      public function getAllAdmins() {
            $stmt = $this->db->prepare("SELECT id, username, access_rights FROM users WHERE access_rights = 2");
            $stmt->execute();
            return $stmt->fetchAll();
      }

      /**
       * Update a user's access rights.
       */
      public function updateUserAccess($user_id, $new_access_rights) {
            $stmt = $this->db->prepare("UPDATE users SET access_rights = ? WHERE id = ?");
            // Pass parameters in order of the placeholders '?'
            return $stmt->execute([$new_access_rights, $user_id]);
      }

      /**
       * Delete a user.
       */
      public function deleteUser($user_id) {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$user_id]);
      }

      /**
       * Reassign all articles from a deleted user to a new author ID.
       */
      public function reassignUserArticles($user_id, $new_author_id = 0) {
            $stmt = $this->db->prepare("UPDATE articles SET author_id = ? WHERE author_id = ?");
            // Pass parameters in order
            return $stmt->execute([$new_author_id, $user_id]);
      }
}