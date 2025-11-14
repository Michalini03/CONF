<?php
session_start();

require __DIR__ . '/../../src/Components/Admin/AdminController.php'; 
header('Content-Type: application/json');
$action = $_GET['action'] ?? $_POST['action'] ?? null; 

$adminController = new AdminController();

// 4. Use a switch to decide what to do

switch ($action) {
    case 'fetchAdmins':
        // Check for Admin-level access
        if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 3) {
            http_response_code(403); // Forbidden
            echo json_encode(['success' => false, 'message' => 'Access denied.']);
            exit;
        }
        
        $response = $adminController->fetchAllAdmins();
        echo json_encode($response);
        break;

    case 'fetchUsers':
        // Check for Editor-level access (or higher)
        if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 2) {
            http_response_code(403); // Forbidden
            echo json_encode(['success' => false, 'message' => 'Access denied.']);
            exit;
        }
        
        $response = $adminController->fetchAllUsers();
        echo json_encode($response);
        break;

    case 'updateUserRights':
        if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 2) {
            http_response_code(403); // Forbidden
            echo json_encode(['success' => false, 'message' => 'Access denied.']);
            exit;
        }

        $user_id = $_POST['user_id'] ?? null;
        $new_access_rights = $_POST['access_rights'] ?? null;

        $response = $adminController->updateUserAccess($user_id, $new_access_rights);
        echo json_encode($response);
        break;

    case 'deleteUser':
        if (!isset($_SESSION['access_rights']) || $_SESSION['access_rights'] < 2) {
            http_response_code(403); // Forbidden
            echo json_encode(['success' => false, 'message' => 'Access denied.']);
            exit;
        }

        $user_id = $_POST['user_id'] ?? null;
        $response = $adminController->deleteUser($user_id);
        echo json_encode($response);
        break;

    default:
        // No valid action was provided
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        break;
}

exit;