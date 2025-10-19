<?php

class ArticleModel {
      private $db;
      public function __construct($db) {
            $this->db = $db;
      }

      public function getArticlesByUserId($user_id) {
            $stmt = $this->db->prepare("SELECT * FROM articles WHERE author_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
      }

      public function insertArticle($user_id, $title, $description, $filename) {
            $stmt = $this->db->prepare("INSERT INTO articles (author_id, title, description, file_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $title, $description, $filename);
            if ($stmt->execute()) {
                  return $this->db->insert_id;
            } else {
                  return false;
            }
      }

      public function savePDFFile($file) {
            $uploadDir = __DIR__ . '/../../../public/uploads/';
            if (!is_dir($uploadDir)) {
                  mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename to avoid overwriting
            $uniqueName = uniqid() . '_' . basename($file['name']);
            $targetFilePath = $uploadDir . $uniqueName;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                  // Return the relative path for DB storage
                  return '/CONF/public/uploads/' . $uniqueName;
            } else {
                  return false; // failed to save
            }
      }

      public function updateArticle($article_id, $title, $description, $filename = null) {
            if ($filename) {
                  $stmt = $this->db->prepare("UPDATE articles SET title = ?, description = ?, file_name = ? WHERE id = ?");
                  $stmt->bind_param("sssi", $title, $description, $filename, $article_id);
            } else {
                  $stmt = $this->db->prepare("UPDATE articles SET title = ?, description = ? WHERE id = ?");
                  $stmt->bind_param("ssi", $title, $description, $article_id);
            }
            return $stmt->execute();
      }

      public function deleteArticle($article_id) {
            $stmt = $this->db->prepare("DELETE FROM articles WHERE id = ?");
            $stmt->bind_param("i", $article_id);
            return $stmt->execute();
      }

      public function deleteOldFile($article_id) {
            $file_name = "";

            $stmt = $this->db->prepare("SELECT file_name FROM articles WHERE id = ?");
            $stmt->bind_param("i", $article_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $file_name_parts = explode('/', $row['file_name']);
            $file_name_last = end($file_name_parts);

            if ($file_name_last) {
                  $filePath = __DIR__ . '/../../../public/uploads/' . $file_name_last;
                  if (file_exists($filePath)) {
                        unlink($filePath);
                  }
            }
      }

      public function checkForAvaiableName($title, $excludeArticleId = -1) {
            $count = null;
            $stmt = $this->db->prepare("SELECT COUNT(id) FROM articles WHERE title = ? AND id != ?");
            $stmt->bind_param("si", $title, $excludeArticleId);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            return $count == 0;
      }
}