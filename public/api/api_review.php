<?php
session_start();

require __DIR__ . '/../../src/Components/ReviewList/ReviewController.php'; 
header('Content-Type: application/json');
$action = $_GET['action'] ?? $_POST['action'] ?? null; 

$reviewController = new ReviewController();

switch ($action) {
      case 'fetchReviewList':
            if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 2) {
                  http_response_code(403); // Forbidden
                  echo json_encode(['success' => false, 'message' => 'Access denied.']);
                  exit;
            }
            $user_id = $_GET['user_id'] ?? null;
            $response = $reviewController->fetchReviewList($user_id);
            echo json_encode($response);
            break;
      
      case 'addReview':
            if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 2) {
                  http_response_code(403); // Forbidden
                  echo json_encode(['success' => false, 'message' => 'Access denied.']);
                  exit;
            }
            $article_id = $_POST['article_id'] ?? null;
            $text = $_POST['text'] ?? null;
            $response = $reviewController->addReview($article_id, $text);
            echo json_encode($response);
            break;

      default:
            $response = ['success'=> false,'message'=> 'Unknown action'];
            echo json_encode($response);
            break;
}