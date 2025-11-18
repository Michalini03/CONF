<?php
session_start();

require __DIR__ . '/../../src/Components/ArticleList/ArticleController.php'; 
header('Content-Type: application/json');
$action = $_GET['action'] ?? $_POST['action'] ?? null; 

$articleController = new ArticleController();

switch ($action) {
      case 'fetchArticles':
            $response = $articleController->fetchAllArticles();
            echo json_encode($response);
            break;

      case 'fetchArticleById':
            $user_id = $_GET['user_id'] ?? null;
            $response = $articleController->fetchUserArticles($user_id);
            echo json_encode($response);
            break;

       case 'createArticle':
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $file = isset($_FILES['file']) ? $_FILES['file'] : null;
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            $response = $articleController->createArticle($userId, $title, $description, $file);
            echo json_encode($response);
            break;

      case 'editArticle':
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $articleId = isset($_POST['article_id']) ? trim($_POST['article_id']) : false;
            $file = isset($_FILES['file']) ? $_FILES['file'] : null;

            $response = $articleController->editArticle($articleId, $title, $description, $file);
            echo json_encode($response);
            break;

      case 'deleteArticle':
            $article_id = isset($_POST['article_id']) ? trim($_POST['article_id']) : false;

            $response = $articleController->deleteArticle($article_id);
            echo json_encode($response);
            break;

      default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
}