<?php
session_start();
require __DIR__ . '/src/Core/Router.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router();

// Define routes
$router->add('/', 'Dashboard/DashboardController.php');
$router->add('/login', 'Login/LoginController.php');
$router->add('/dashboard', 'Dashboard/DashboardController.php');
$router->add('/logout', 'Login/LogoutController.php');

// Dispatch
$router->dispatch($request);
