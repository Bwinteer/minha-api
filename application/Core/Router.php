<?php
namespace BrunaW\MinhaApi\Core;
class Router {
    private $routes = [];

    public function get($pattern, $handler) {
        $this->addRoute('GET', $pattern, $handler);
    }

    public function post($pattern, $handler) {
        $this->addRoute('POST', $pattern, $handler);
    }

    public function put($pattern, $handler) {
        $this->addRoute('PUT', $pattern, $handler);
    }

    public function delete($pattern, $handler) {
        $this->addRoute('DELETE', $pattern, $handler);
    }

    private function addRoute($method, $pattern, $handler) {
        $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(\d+)', $pattern) . '$#';
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // Remove o primeiro elemento (a string completa)
                if (is_array($route['handler'])) {
                    $controller = new $route['handler'][0]();
                    $method = $route['handler'][1];
                    return call_user_func_array([$controller, $method], $matches);
                }
                if (is_callable($route['handler'])) {
                    return call_user_func_array($route['handler'], $matches);
                }
                http_response_code(500);
                echo "Handler inválido.";
                return;
            }
        }
    }
}