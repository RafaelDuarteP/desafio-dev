<?php

class Router {
    private $routes = [];

    public function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([a-zA-Z0-9_]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $callback = $route['callback'];
                $callback($matches);
                return;
            }
        }

        Response::send(404, ['error' => 'Not found']);
    }
}