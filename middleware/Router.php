<?php

class Router
{
    private $routes = array();

    public function register($method, $path, $action)
    {
        $this->routes[strtoupper($method)][$path] = $action;
    }

    public function dispatch($method, $uri) {
        $basepath = dirname($_SERVER['SCRIPT_NAME']); // Remove the basepath from the URI
    
        if (substr($uri, 0, strlen($basepath)) == $basepath) {
            $uri = substr($uri, strlen($basepath));
        }
    
        $method = strtoupper($method);
    
        if (isset($this->routes[$method][$uri])) {
            // Store the result of the action in a variable $data
            $data = call_user_func($this->routes[$method][$uri]);
    
            // Debugging code
            error_log(print_r($data, true));
    
            header('Content-Type: application/json');
            echo ($data);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Resource not found.'
            ]);
        }
    }
    
}