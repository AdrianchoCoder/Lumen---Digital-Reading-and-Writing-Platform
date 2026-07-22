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
<body class="auth-body">
    <div class="auth-wrap">
        <div class="auth-top">
            <a class="brand" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/">
                <span class="brand-mark">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 2.4 4.9 5.4.8-3.9 3.8.9 5.4L12 15.9 7.2 18l.9-5.4L4.2 8.7l5.4-.8L12 3Z" fill="none" stroke="currentColor" stroke-width="1.7"/></svg>
                </span>
                <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?>
            </a>
            <div class="top-actions">
                <button type="button" class="icon-btn" id="theme-toggle" title="Cambiar tema" aria-label="Cambiar tema claro/oscuro">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
                </button>
                <?php if (!is_array($authUser)): ?>
                    <a class="btn btn-small btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Entrar</a>
                    <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>

        <main class="guest-shell">
            <?php if (!empty($flashSuccess)): ?>
                <p class="flash flash-ok"><?= htmlspecialchars((string) $flashSuccess, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <?php if (!empty($flashError)): ?>
                <p class="flash flash-err"><?= htmlspecialchars((string) $flashError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <?= $content ?>
        </main>
    </div>
    <script src="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/js/theme.js"></script>
</body>
</html>
