<?php
session_start();

require __DIR__ . '/../../src/Components/Login/LoginController.php'; 
header('Content-Type: application/json');
$action = $_GET['action'] ?? $_POST['action'] ?? null; 

$login = new LoginController();

switch ($action) {
      case 'login':
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            $response = $login->checkUserInfoInDB($username, $password);
            echo json_encode($response);
            break;

      case 'logout':
            $_SESSION = [];
            session_destroy();
            header('Location: /login');
            break;

      case 'register':
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $email = $_POST['email'] ?? null;

            $response = $login->registerNewUser($username, $password);
            echo json_encode($response);
            break;

      default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
}