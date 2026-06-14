<?php
// ============================================================
// COSMEET — Router
// ============================================================
namespace Cosmeet\Core;

class Router {
    private array $routes = [];

    public function get(string $path, array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void {
        $uri = strtok($uri, '?');
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$controllerName, $action] = $handler;
                $class = 'Cosmeet\\Controllers\\' . $controllerName;
                $controller = new $class();
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }
        // 404
        http_response_code(404);
        require VIEW_PATH . '/errors/404.php';
    }
}
