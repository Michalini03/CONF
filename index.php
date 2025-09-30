<?php
session_start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request) {
    case '/CONF':
    case '/CONF/':
    case '/myapp/CONF/index.php':
        require __DIR__ . '/index.php';
        break;

    case '/CONF/login':
        require __DIR__ . '/src/Controllers/LoginController.php';
        break;

      case '/CONF/dashboard':
            require __DIR__ . '/src/Controllers/DashboardController.php';
            break;

      case '/CONF/logout':
            session_destroy();
            header("Location: /CONF/login");
            break;
      default:
            http_response_code(404);
            echo "404 Not Found";
            break;
}