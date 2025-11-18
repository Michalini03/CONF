<?php
session_start();

require __DIR__ . '/../../src/Components/Dashboard/DashboardController.php'; 
header('Content-Type: application/json');
$action = $_GET['action'] ?? $_POST['action'] ?? null; 

$dashboardController = new DashboardController();

switch ($action) {
      case 'fetchDashboardData':
            $index = $_GET['index'] ?? null;
            $response = $dashboardController->fetchDashboardData($index);
            echo json_encode($response);
            break;
      
      default:
            $response = ['success'=> false,'message'=> 'Unknown action'];
            echo json_encode($response);
            break;
}