<?php

declare(strict_types=1);

namespace App\Core;

use App\Middleware\RoleMiddleware;

/**
 * Enrutador HTTP mínimo: mapea método + URI a controlador@acción.
 *
 * Soporte de middleware por ruta (módulo 8):
 *   $router->get('/escribir', [WriterController::class, 'hub'], ['role:escritor']);
 *   $router->get('/admin', [AdminController::class, 'dashboard'], ['role:administrador']);
 *   $router->get('/inicio', [ReaderController::class, 'home'], ['auth']);
 */
final class Router
{
    /** @var array<int, array{methods: string[], pattern: string, handler: callable|array, middleware: string[]}> */
    private array $routes = [];

    public function get(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->add(['GET'], $path, $handler, $middleware);
    }

    public function post(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->add(['POST'], $path, $handler, $middleware);
    }

    public function match(array $methods, string $path, callable|array $handler, array $middleware = []): void
    {
        $this->add($methods, $path, $handler, $middleware);
    }

    private function add(array $methods, string $path, callable|array $handler, array $middleware = []): void
    {
        $this->routes[] = [
            'methods'    => array_map('strtoupper', $methods),
            'pattern'    => $this->compile($path),
            'handler'    => $handler,
            'middleware' => $middleware,
        ];
    }

    private function compile(string $path): string
    {
        $path = '/' . trim($path, '/');
        if ($path === '/') {
            return '#^/$#';
        }

        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $path);

        return '#^' . $pattern . '$#';
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        $path = '/' . trim($path, '/');
        if ($path !== '/') {
            $path = rtrim($path, '/') ?: '/';
        }

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $base = str_replace('\\', '/', dirname($scriptName));
        if ($base !== '/' && $base !== '.' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base)) ?: '/';
            $path = '/' . ltrim($path, '/');
        }

        foreach ($this->routes as $route) {
            if (!in_array($method, $route['methods'], true)) {
                continue;
            }

            if (!preg_match($route['pattern'], $path, $matches)) {
                continue;
            }

            $params = array_filter(
                $matches,
                static fn ($key) => !is_int($key),
                ARRAY_FILTER_USE_KEY
            );

            foreach ($route['middleware'] as $rule) {
                RoleMiddleware::handle($rule);
            }

            $this->invoke($route['handler'], $params);
            return;
        }

        http_response_code(404);
        echo '404 — Página no encontrada';
    }

    private function invoke(callable|array $handler, array $params): void
    {
        if (is_array($handler)) {
            [$class, $action] = $handler;
            $controller = is_object($class) ? $class : new $class();
            $controller->{$action}(...array_values($params));
            return;
        }

        $handler(...array_values($params));
    }
}
