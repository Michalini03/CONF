<?php

class ArticleModel {
      private $db;
      
      public function __construct($db) {
            $this->db = $db;
      }

      /**
       * Get all articles.
       */
      public function getAllArticles() {
            $stmt = $this->db->prepare("SELECT * FROM articles");
            $stmt->execute();
            return $stmt->fetchAll();
      }


      /**
       * Get articles for a specific user.
       */
      public function getArticlesByUserId($user_id) {
            $stmt = $this->db->prepare("SELECT * FROM articles WHERE author_id = ?");
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(); // Uses default FETCH_ASSOC
      }

      /**
       * Insert a new article and return its ID.
       */
      public function insertArticle($user_id, $title, $description, $filename) {
            $sql = "INSERT INTO articles (author_id, title, description, file_name) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            
            // Pass params in array
            $success = $stmt->execute([$user_id, $title, $description, $filename]);
            
            if ($success) {
                  return $this->db->lastInsertId();
            } else {
                  return false;
            }
      }

      /**
       * Save the PDF file and return ONLY the unique filename.
       * Storing the full path in the DB is bad practice.
       */
      public function savePDFFile($file) {
            $uploadDir = __DIR__ . '/../../../public/uploads/';
            if (!is_dir($uploadDir)) {
                  mkdir($uploadDir, 0755, true);
            }

            $uniqueName = uniqid() . '_' . basename($file['name']);
            $targetFilePath = $uploadDir . $uniqueName;

            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                  // SUCCESS: Return ONLY the filename
                  return $uniqueName;
            } else {
                  return false;
            }
      }

      /**
       * Update an article.
       */
      public function updateArticle($article_id, $title, $description, $filename = null) {
            if ($filename) {
                  // If a new file is provided
                  $stmt = $this->db->prepare("UPDATE articles SET title = ?, description = ?, file_name = ? WHERE id = ?");
                  return $stmt->execute([$title, $description, $filename, $article_id]);
            } else {
                  // If no new file is provided
                  $stmt = $this->db->prepare("UPDATE articles SET title = ?, description = ? WHERE id = ?");
                  return $stmt->execute([$title, $description, $article_id]);
            }
      }

      /**
       * Delete an article.
       */
      public function deleteArticle($article_id) {
            $stmt = $this->db->prepare("DELETE FROM articles WHERE id = ?");
            return $stmt->execute([$article_id]);
      }

      /**
       * Delete the physical file from the server.
       * This is much simpler now that we only store the filename.
       */
      public function deleteOldFile($article_id) {
            $stmt = $this->db->prepare("SELECT file_name FROM articles WHERE id = ?");
            $stmt->execute([$article_id]);
            $row = $stmt->fetch(); // Gets the first (and only) row

            // Check if $row is valid AND file_name is not empty
            if ($row && !empty($row['file_name'])) {
                  $filePath = __DIR__ . '/../../../public/uploads/' . $row['file_name'];
                  if (file_exists($filePath)) {
                  unlink($filePath);
                  }
            }
      }

      /**
       * Check if a title is available (excluding a specific article ID).
       */
      public function checkForAvaiableName($title, $excludeArticleId = -1) {
            $stmt = $this->db->prepare("SELECT COUNT(id) FROM articles WHERE title = ? AND id != ?");
            $stmt->execute([$title, $excludeArticleId]);
            
            // fetchColumn() is perfect for getting a single value (the count)
            $count = $stmt->fetchColumn(); 
            
            return $count == 0;
      }
}