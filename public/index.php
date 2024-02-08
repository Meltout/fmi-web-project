<?php

require __DIR__ . '/../vendor/autoload.php';

// Define your routes
$routes = [
    'GET' => [
        '/' => 'HomeController@show',
        '/table/(\d+)' => 'TableController@show', 
    ],
    'POST' => [
        // Add more POST routes as needed
    ]
];

// Get the current URL
$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Check if the route exists
$routeFound = false;
if (isset($routes[$method])) {
    foreach ($routes[$method] as $route => $controllerAction) {
        // Convert route to regex pattern
        $pattern = '#^' . preg_replace('#/:([^/]+)#', '/([^/]+)', $route) . '$#';
        
        // Check if the URL matches the pattern
        if (preg_match($pattern, $url, $matches)) {
            // Remove the first match which is the full URL
            array_shift($matches);
            
            // Split the controller and method
            $parts = explode('@', $controllerAction);
            
            // Get the controller and method names
            $controllerName = '\\Controllers\\' . $parts[0];
            $methodName = $parts[1];
            
            // Create an instance of the controller
            $controller = new $controllerName;
            
            // Call the controller method with parameters
            call_user_func_array([$controller, $methodName], $matches);
            
            $routeFound = true;
            break;
        }
    }
}

if (!$routeFound) {
    // Route not found, handle accordingly
    echo '404 - Page not found';
}