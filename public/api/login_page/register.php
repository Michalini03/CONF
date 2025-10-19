<?php
session_start();
header('Content-Type: application/json');
require_once '../../../src/Components/Login/LoginController.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($username === null || $password === null) {
    echo json_encode(['success' => false, 'message' => 'Error fetching data']);
    exit;
}

$controller = new LoginController();
$response = $controller->registerNewUser($username, $password);

echo json_encode($response);
exit;
