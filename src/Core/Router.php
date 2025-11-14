<?php
class Router {
    private $routes = [];
    private $basePath = '/'; 

    /**
     * Add a route.
     * $controllerAction can be a filename (for simple files)
     * or an array [ 'controller' => 'ClassName', 'method' => 'methodName' ]
     */
    public function add($path, $controllerAction) {
        // Normalize the path
        $fullPath = rtrim($this->basePath . rtrim($path, '/'), '/');
        if (empty($fullPath)) $fullPath = $this->basePath; // Handle root
        if (empty($fullPath)) $fullPath = '/'; // Handle absolute root

        $this->routes[$fullPath] = $controllerAction;
    }

    public function dispatch($request) {
        // Normalize the request path
        $request = rtrim($request, '/');
        if (empty($request)) $request = '/'; // Handle root

        // Check if the route exists
        if (isset($this->routes[$request])) {
            $routeAction = $this->routes[$request];

            // === NEW LOGIC ===
            
            // Case 1: Route is an array (MVC Class/Method)
            if (is_array($routeAction)) {
                $componentName = $routeAction['component'];
                $controllerName = $routeAction['controller'];
                $methodName = $routeAction['method'];
                
                // Assumes controllers are in /src/Controllers/
                $controllerFile = __DIR__ . '/../Components/' . $componentName . '/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;

                    if (class_exists($controllerName)) {
                        $controller = new $controllerName(); // Create instance
                        
                        if (method_exists($controller, $methodName)) {
                            $controller->$methodName(); // Call the method
                        } else {
                            $this->sendError("Method '{$methodName}' not found in controller '{$controllerName}'");
                        }
                    } else {
                        $this->sendError("Controller class '{$controllerName}' not found");
                    }
                } else {
                    $this->sendError("Controller file not found: {$controllerFile}");
                }

            // Case 2: Route is a string (Simple File - for your api.php)
            } elseif (is_string($routeAction)) {
                // Assumes the file is in /public/
                $filePath = __DIR__ . '/../../public/' . $routeAction; 

                if (file_exists($filePath)) {
                    require $filePath;
                } else {
                    $this->sendError("File not found: {$filePath}");
                }
            
            // Error case
            } else {
                $this->sendError("Invalid route configuration.");
            }

        } else {
            // No route matched
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    // Helper function for sending errors
    private function sendError($message) {
        http_response_code(500);
        echo "Server Error: " . htmlspecialchars($message);
    }
}