<?php

session_start();
header('Content-Type: application/json');

require_once '../../../src/Components/ArticleList/ArticleController.php';
$articleController = new ArticleController();

// Validate POST + FILES
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$articleId = isset($_POST['article_id']) ? trim($_POST['article_id']) : false;
$file = isset($_FILES['file']) ? $_FILES['file'] : null;

$response = $articleController->editArticle($articleId, $title, $description, $file);
echo json_encode($response);
exit;