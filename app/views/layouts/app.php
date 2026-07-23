<?php
/** @var string $content */
/** @var string $appName */
/** @var string $appUrl */
/** @var string $title */
/** @var array|null $authUser */
/** @var string|null $flashSuccess */
/** @var string|null $flashError */
/** @var string $currentPath */

$appName = $appName ?? 'Lumen';
$appUrl = $appUrl ?? '';
$currentPath = $currentPath ?? '/';
$pageTitle = (!empty($title) && $title !== $appName)
    ? $title . ' — ' . $appName
    : $appName;

$nav = static function (string $path, string $currentPath): string {
    if ($path === '/escribir') {
        $inWriterHome = $currentPath === '/escribir' || str_starts_with($currentPath, '/escribir/libros');

        return $inWriterHome ? 'active' : '';
    }

    return $currentPath === $path ? 'active' : '';
};

$role = is_array($authUser) ? (string) ($authUser['role'] ?? '') : '';
$isWriterPlus = in_array($role, ['escritor', 'administrador'], true);
$isAdmin = $role === 'administrador';

$icon = static function (string $name): string {
    $icons = [
        'home' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5Z"/></svg>',
        'compass' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m16 8-2.5 6.5L7 17l2.5-6.5L16 8Z"/></svg>',
        'book' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v16H7.5A2.5 2.5 0 0 0 5 20.5V4.5Z"/><path d="M5 20.5A2.5 2.5 0 0 1 7.5 18H20"/></svg>',
        'user' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M5 19.5c1.8-3.2 4.2-4.5 7-4.5s5.2 1.3 7 4.5"/></svg>',
        'pen' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 20 4.5-1.2L19 8.3a2 2 0 0 0 0-2.8l-.5-.5a2 2 0 0 0-2.8 0L5.2 15.5 4 20Z"/><path d="m13.5 6.5 4 4"/></svg>',
        'users' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M3.5 19c1.5-2.8 3.5-4 5.5-4s4 1.2 5.5 4"/><path d="M14 15c1.6 0 3 .7 4.5 2.5"/></svg>',
        'chart' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16"/><path d="M7 16V9"/><path d="M12 16V5"/><path d="M17 16v-6"/></svg>',
        'star' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 2.4 4.9 5.4.8-3.9 3.8.9 5.4L12 15.9 7.2 18l.9-5.4L4.2 8.7l5.4-.8L12 3Z"/></svg>',
        'shield' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 5 6.5v5.2c0 4.2 2.8 7.8 7 9.3 4.2-1.5 7-5.1 7-9.3V6.5L12 3Z"/></svg>',
        'plus' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>',
    ];

    return $icons[$name] ?? '';
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <script>
        (function () {
            try {
                var t = localStorage.getItem('lumen-theme');
                if (t === 'light') document.documentElement.setAttribute('data-theme', 'light');
            } catch (e) {}
        })();
    </script>
    <link rel="stylesheet" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/css/app.css">
</head>
<body class="app-body">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a class="sidebar-logo-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/inicio" aria-label="Ir al inicio — logo">
                <span class="logo-slot sidebar-logo-slot">
                    <img
                        src="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/img/logo.png"
                        alt=""
                        class="logo-img"
                    >
                </span>
            </a>
            <a class="sidebar-brand-text" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/inicio"><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></a>
        </div>
        <nav class="side-nav">
            <a class="<?= $nav('/inicio', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/inicio"><?= $icon('home') ?> Inicio</a>
            <a class="<?= $nav('/descubrir', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir"><?= $icon('compass') ?> Descubrir</a>
            <a class="<?= $nav('/biblioteca', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca"><?= $icon('book') ?> Biblioteca</a>
            <a class="<?= $nav('/perfil', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/perfil"><?= $icon('user') ?> Perfil</a>
            <?php if ($role === 'lector'): ?>
                <a class="<?= $nav('/solicitar-escritor', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/solicitar-escritor"><?= $icon('pen') ?> Ser escritor</a>
            <?php endif; ?>
            <?php if ($isWriterPlus): ?>
                <p class="nav-section">Escritor</p>
                <a class="<?= $nav('/escribir', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir"><?= $icon('pen') ?> Escribir</a>
                <a class="<?= $currentPath === '/escribir/comunidades' || str_starts_with($currentPath, '/escribir/comunidades/') ? 'active' : '' ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/comunidades"><?= $icon('users') ?> Comunidades</a>
                <a class="<?= $currentPath === '/escribir/estadisticas' ? 'active' : '' ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/estadisticas"><?= $icon('chart') ?> Estadísticas</a>
                <a class="nav-cta" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/nueva"><?= $icon('plus') ?> Nueva historia</a>
            <?php endif; ?>
            <?php if ($isAdmin): ?>
                <p class="nav-section">Admin</p>
                <a class="<?= str_starts_with($currentPath, '/admin') ? 'active' : '' ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin"><?= $icon('shield') ?> Admin</a>
            <?php endif; ?>
        </nav>
        <div class="side-footer">
            <?php if (is_array($authUser)): ?>
                <p class="nav-user"><?= htmlspecialchars($authUser['display_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                <p class="nav-role"><?= htmlspecialchars($authUser['role'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/logout">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="linkish">Cerrar sesión</button>
                </form>
            <?php endif; ?>
        </div>
    </aside>

    <div class="app-shell">
        <header class="top-chrome">
            <form class="top-search" method="get" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir" role="search">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <input type="search" name="q" placeholder="Buscar historias, géneros o autores…" aria-label="Buscar">
            </form>
            <div class="top-actions">
                <button type="button" class="icon-btn" id="theme-toggle" title="Cambiar tema" aria-label="Cambiar tema claro/oscuro">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
                </button>
                <button type="button" class="icon-btn" title="Notificaciones (próximamente)" aria-label="Notificaciones">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 17h12l-1.2-1.2A2 2 0 0 1 16 14.4V11a4 4 0 1 0-8 0v3.4a2 2 0 0 1-.8 1.4L6 17Z"/><path d="M10 17a2 2 0 0 0 4 0"/></svg>
                    <span class="badge" aria-hidden="true"></span>
                </button>
            </div>
        </header>

        <div class="app-main">
            <?php if (!empty($flashSuccess)): ?>
                <p class="flash flash-ok"><?= htmlspecialchars((string) $flashSuccess, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <?php if (!empty($flashError)): ?>
                <p class="flash flash-err"><?= htmlspecialchars((string) $flashError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
    <script src="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/js/theme.js"></script>
</body>
</html>
