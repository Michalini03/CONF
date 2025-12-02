<?php
session_start();
require __DIR__ . '/src/Core/Router.php';
require __DIR__ . '/src/Core/DatabaseConnector.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router();

// Define routes
$router->add('/', ['component' => 'Dashboard', 'controller' => 'DashboardController', 'method' => 'showDashboard']);
$router->add('dashboard', ['component' => 'Dashboard', 'controller' => 'DashboardController', 'method' => 'showDashboard']);
$router->add('login', ['component' => 'Login', 'controller' => 'LoginController', 'method' => 'showForm']);
$router->add('admin', ['component' => 'Admin', 'controller' => 'AdminController', 'method' => 'showAdminPage']);
$router->add('myarticles', ['component' => 'ArticleList', 'controller' => 'ArticleController', 'method' => 'showArticlePage']);
$router->add('myreviews', ['component' => 'ReviewList', 'controller' => 'ReviewController', 'method' => 'showReviewPage']);

// Dispatch
$router->dispatch($request);
