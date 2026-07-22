<?php
/** @var string $content */
/** @var string $appName */
/** @var string $appUrl */
/** @var string $title */
/** @var array|null $authUser */
/** @var string|null $flashSuccess */
/** @var string|null $flashError */

$appName = $appName ?? 'Lumen';
$appUrl = $appUrl ?? '';
$pageTitle = (!empty($title) && $title !== $appName)
    ? $title . ' — ' . $appName
    : $appName;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/css/app.css">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/"><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></a>
        <nav class="topnav">
            <?php if (is_array($authUser)): ?>
                <span class="nav-user"><?= htmlspecialchars($authUser['display_name'] ?? '', ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($authUser['role'] ?? '', ENT_QUOTES, 'UTF-8') ?>)</span>
                <form class="inline-form" method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/logout">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="linkish">Cerrar sesión</button>
                </form>
            <?php else: ?>
                <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Entrar</a>
                <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="shell">
        <?php if (!empty($flashSuccess)): ?>
            <p class="flash flash-ok"><?= htmlspecialchars((string) $flashSuccess, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <?php if (!empty($flashError)): ?>
            <p class="flash flash-err"><?= htmlspecialchars((string) $flashError, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>
</html>
