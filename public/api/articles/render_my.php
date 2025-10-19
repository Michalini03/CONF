<?php
session_start();
header('Content-Type: application/json');
require_once '../../../src/Components/ArticleList/ArticleController.php';

$controller = new ArticleController();
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    echo json_encode(['success' => false, 'message' => 'Error fetching data']);
    exit;
}

$articles = $controller->fetchUserArticles($user_id);
echo json_encode(['success' => true, 'articles' => $articles]);
exit;