<?php
class DashboardModel {

    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchDashboardData($index) {
      $stmt = $this->db->prepare("
            SELECT 
                  a.id as id, 
                  a.title as title,
                  a.description as description, 
                  a.file_name as file_name, 
                  a.last_edited as last_edited,
                  s.username as author
            FROM articles AS a
            LEFT JOIN users AS s ON a.author_id = s.id
            ORDER BY a.id
            LIMIT 5 OFFSET ?
      ");

      $stmt->execute([(int)$index]);
      $row = $stmt->fetchAll();

      return $row;
    }

    public function getArticleCount() {
      $stmt = $this->db->prepare("SELECT COUNT(id) as count FROM `articles`");
      $stmt->execute();
      $row = $stmt->fetch();

      return $row["count"];
    }

}