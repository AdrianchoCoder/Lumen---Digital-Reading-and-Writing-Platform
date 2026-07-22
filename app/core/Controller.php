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

        $authUser = Session::get('user');

        $data = array_merge([
            'appName'      => $this->config['app']['name'] ?? 'Lumen',
            'appUrl'       => rtrim($this->config['app']['url'] ?? '', '/'),
            'authUser'     => $authUser,
            'flashSuccess' => Session::pullFlash('success'),
            'flashError'   => Session::pullFlash('error'),
            'title'        => $this->config['app']['name'] ?? 'Lumen',
            'currentPath'  => $this->currentPath(),
        ], $data);

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

    protected function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    protected function isLoggedIn(): bool
    {
        $user = Session::get('user');

        return is_array($user) && isset($user['id']);
    }

    /** @return array{id:int,username:string,email:string,display_name:string,role:string} */
    protected function requireAuth(): array
    {
        $user = Session::get('user');

        if (!is_array($user) || !isset($user['id'])) {
            Session::flash('error', 'Debes iniciar sesión para continuar.');
            $this->redirect('/login');
        }

        return $user;
    }

    protected function assertCsrf(): bool
    {
        $token = isset($_POST['_csrf']) && is_string($_POST['_csrf']) ? $_POST['_csrf'] : null;

        if (!Csrf::validate($token)) {
            Session::flash('error', 'Token de seguridad inválido. Intenta de nuevo.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
            return false;
        }

        return true;
    }

    protected function stringInput(string $key, string $source = 'post'): string
    {
        $bag = $source === 'get' ? $_GET : $_POST;
        $value = $bag[$key] ?? '';

        if (!is_string($value)) {
            return '';
        }

        return trim($value);
    }

    protected function currentPath(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $base = str_replace('\\', '/', dirname($scriptName));

        if ($base !== '/' && $base !== '.' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base)) ?: '/';
            $path = '/' . ltrim($path, '/');
        }

        return rtrim($path, '/') ?: '/';
    }
}
