<?php
class DashboardModel {

    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function fetchDashboardData($index) {
      $stmt = $this->db->prepare("
        SELECT 
            a.id AS id, 
            a.title AS title,
            a.description AS description, 
            a.file_name AS file_name, 
            a.last_edited AS last_edited,
            s.username AS author
        FROM articles AS a
        LEFT JOIN users AS s ON a.author_id = s.id
        WHERE a.state = 4
        ORDER BY a.id
        LIMIT 5 OFFSET ?
    ");

      $stmt->execute([(int)$index]);
      $row = $stmt->fetchAll();

      return $row;
    }

    public function getArticleCount() {
      $stmt = $this->db->prepare("SELECT COUNT(id) as count FROM `articles` WHERE state = 4");
      $stmt->execute();
      $row = $stmt->fetch();

      return $row["count"];
    }

    public function fetchDashboardDataFiltered($index, $filter) {
      $sql = "
          SELECT 
              a.id AS id, 
              a.title AS title,
              a.description AS description, 
              a.file_name AS file_name, 
              a.last_edited AS last_edited,
              s.username AS author
          FROM articles AS a
          LEFT JOIN users AS s ON a.author_id = s.id
          WHERE a.state = 4
      ";

      if (!empty($filter)) {
          $sql .= " AND (a.title LIKE ? OR a.description LIKE ?)";
      }

      $sql .= " ORDER BY a.id LIMIT 5 OFFSET ?";

      $stmt = $this->db->prepare($sql);

      $filterParam = '%' . $filter . '%';


      $stmt->execute([$filterParam, $filterParam, $index]);
      $row = $stmt->fetchAll();

      return $row;
  }

    public function getArticleCountFiltered($filter) {
      $sql = "SELECT COUNT(id) AS count FROM articles WHERE state = 4";
      $filterParam = '%' . $filter . '%';

      if (!empty($filter)) {
          $sql .= " AND (title LIKE ? OR description LIKE ?)";
      }

      $stmt = $this->db->prepare($sql);

      $stmt->execute([$filterParam, $filterParam]);
      $row = $stmt->fetch();

      return $row["count"];
  }
}