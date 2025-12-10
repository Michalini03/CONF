<?php

class ReviewModel {
      private $db;

      public function __construct($dbConnection) {
            $this->db = $dbConnection;
      }

      public function fetchReviewList($review_id) {
            $stmt = $this->db->prepare("SELECT * FROM articles WHERE reviewer_id = ? AND state = 2 OR state = 3");
            $stmt->execute([$review_id]);
            return $stmt->fetchAll();
      }

      public function addReview($article_id, $text) {
            $stmt = $this->db->prepare("
                  UPDATE articles
                  SET review = ?, state = 3
                  WHERE id = ?
            ");
            return $stmt->execute([$text, $article_id]);
      }
}