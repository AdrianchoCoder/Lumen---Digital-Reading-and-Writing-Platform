<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Enrutador HTTP mínimo: mapea método + URI a controlador@acción.
 *
 * Ejemplos de registro:
 *   $router->get('/', [HomeController::class, 'index']);
 *   $router->get('/books/{id}', [BookController::class, 'show']);
 */
final class Router
{
    /** @var array<int, array{methods: string[], pattern: string, handler: callable|array}> */
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->add(['GET'], $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->add(['POST'], $path, $handler);
    }

    public function match(array $methods, string $path, callable|array $handler): void
    {
        $this->add($methods, $path, $handler);
    }

    private function add(array $methods, string $path, callable|array $handler): void
    {
        $this->routes[] = [
            'methods' => array_map('strtoupper', $methods),
            'pattern' => $this->compile($path),
            'handler' => $handler,
        ];
    }

    /**
     * Convierte /books/{id} en una expresión regular con grupos con nombre.
     */
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

        // Si la app vive en un subdirectorio (.../public), se normaliza el path.
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
