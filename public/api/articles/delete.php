<?php

require_once '../../../src/Components/ArticleList/ArticleController.php';
session_start();

header('Content-Type: application/json');
$articleController = new ArticleController();

$articleId = isset($_POST['article_id']) ? trim($_POST['article_id']) : false;
$response = $articleController->deleteArticle($articleId);
echo json_encode($response);
exit;