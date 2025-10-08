<?php
class Router {
    private $routes = [];
    private $basePath = '/CONF'; // set your base path once

      public function add($path, $controller) {
            $fullPath = $this->basePath . rtrim($path, '/');
            if ($fullPath === '') $fullPath = '/';
            $this->routes[$fullPath] = $controller;
      }

    public function dispatch($request) {
        // Normalize the request path (remove trailing slash)
        $request = rtrim($request, '/');

        // Handle base path
        if ($request === '') $request = '/';

        // Look for route
        if (isset($this->routes[$request])) {
            $controllerPath = __DIR__ . '/../Components/' . $this->routes[$request];

            if (file_exists($controllerPath)) {
                require $controllerPath;
            } else {
                http_response_code(500);
                echo "Controller not found: " . htmlspecialchars($controllerPath);
            }

        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
