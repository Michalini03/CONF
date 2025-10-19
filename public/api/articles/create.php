<?php
session_start();
header('Content-Type: application/json');

require_once '../../../src/Components/ArticleList/ArticleController.php';
$articleController = new ArticleController();

// Validate POST + FILES
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$file = isset($_FILES['file']) ? $_FILES['file'] : null;
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Pass to your controller (MVC)
$response = $articleController->createArticle($userId, $title, $description, $file);

// Return JSON response
echo json_encode($response);
exit;