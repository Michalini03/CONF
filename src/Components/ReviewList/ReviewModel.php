<?php

class ReviewModel {
      private $db;

      public function __construct($dbConnection) {
            $this->db = $dbConnection;
      }

}