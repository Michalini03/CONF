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

      public function fetchReviewList($user_id) {
            if ($user_id == null) {
                  return ['success' => false, 'message' => 'Missing required fields.'];
            }

            $data = $this->model->fetchReviewList($user_id);
            if (isset($data)) {
                  return ['success'=> true,'data'=> $data];
            } else {
                  return ['success'=> false,'message'=> 'Error fetching data'];
            }
      }

      public function addReview($article_id, $text) {
            if ($article_id == null || $text == null || $text == '') {
                  return ['success' => false, 'message' => 'Missing required fields.'];
            }

            if($this->model->addReview($article_id, $text)) {
                  return ['success'=> true,'message'=> 'Adding review sucessfull'];
            }
            else {
                  return ['success'=> false,'message'=> 'Error adding review'];
            }
      }
}