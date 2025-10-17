<?php
session_start();
require __DIR__ . '/src/Core/Router.php';
require __DIR__ . '/src/Core/DatabaseConnector.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router();

// Define routes
$router->add('/', 'Dashboard/index.php');
$router->add('/login', 'Login/index.php');
$router->add('/dashboard', 'Dashboard/index.php');

// Dispatch
$router->dispatch($request);
