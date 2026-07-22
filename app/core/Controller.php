<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Controlador base: helpers compartidos por todos los controladores.
 */
abstract class Controller
{
    protected array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 2) . '/config/config.php';
    }

    /**
     * Renderiza una vista PHP dentro de un layout opcional.
     *
     * @param string $view   Ruta relativa a app/views sin extensión (ej: home/index)
     * @param array  $data   Variables disponibles en la vista
     * @param string $layout Layout relativo a app/views/layouts (sin extensión)
     */
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewsPath = dirname(__DIR__) . '/views';
        $viewFile = $viewsPath . '/' . str_replace('.', '/', $view) . '.php';

        if (!is_file($viewFile)) {
            throw new \RuntimeException("Vista no encontrada: {$view}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === '') {
            echo $content;
            return;
        }

        $layoutFile = $viewsPath . '/layouts/' . $layout . '.php';
        if (!is_file($layoutFile)) {
            throw new \RuntimeException("Layout no encontrado: {$layout}");
        }

        require $layoutFile;
    }

    protected function redirect(string $path): void
    {
        $base = rtrim($this->config['app']['url'] ?? '', '/');
        $target = str_starts_with($path, 'http') ? $path : $base . '/' . ltrim($path, '/');
        header('Location: ' . $target);
        exit;
    }

    protected function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
