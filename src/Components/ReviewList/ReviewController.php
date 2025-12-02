<?php
require_once __DIR__ . '/../../Core/BaseController.php';
require_once __DIR__ . '/ReviewModel.php';


class ReviewController extends BaseController {
      private $model;

      public function __construct() {
            parent::__construct();
            $this->model = new ReviewModel($this->db);
      }

      public function showReviewPage() {
            $this->render('ReviewList', 'review_list');
      }
}