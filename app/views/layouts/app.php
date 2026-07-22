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
    return $currentPath === $path ? 'active' : '';
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/css/app.css">
</head>
<body class="app-body">
    <aside class="sidebar">
        <a class="brand" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/inicio"><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></a>
        <nav class="side-nav">
            <a class="<?= $nav('/inicio', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/inicio">Inicio</a>
            <a class="<?= $nav('/descubrir', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Descubrir</a>
            <a class="<?= $nav('/biblioteca', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca">Biblioteca</a>
            <a class="<?= $nav('/perfil', $currentPath) ?>" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/perfil">Perfil</a>
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

    <div class="app-main">
        <?php if (!empty($flashSuccess)): ?>
            <p class="flash flash-ok"><?= htmlspecialchars((string) $flashSuccess, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <?php if (!empty($flashError)): ?>
            <p class="flash flash-err"><?= htmlspecialchars((string) $flashError, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <?= $content ?>
    </div>
</body>
</html>
