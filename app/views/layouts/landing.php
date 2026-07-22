<?php
/** @var string $content */
/** @var string $appName */
/** @var string $appUrl */
/** @var string $title */
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
<body class="landing-body">
    <header class="landing-nav">
        <a class="landing-brand" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/">
            <span class="logo-slot" aria-label="Logo Lumen">
                <img
                    src="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/img/logo.png"
                    alt="<?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?>"
                    class="logo-img"
                >
            </span>
        </a>
        <nav class="landing-nav-links">
            <button type="button" class="icon-btn landing-interactive" id="theme-toggle" title="Cambiar tema" aria-label="Cambiar tema claro/oscuro">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
            </button>
            <a class="landing-nav-link landing-interactive" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Iniciar sesión</a>
            <a class="btn btn-small landing-btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Registro</a>
        </nav>
    </header>

    <?php if (!empty($flashSuccess)): ?>
        <p class="flash flash-ok landing-flash"><?= htmlspecialchars((string) $flashSuccess, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <?php if (!empty($flashError)): ?>
        <p class="flash flash-err landing-flash"><?= htmlspecialchars((string) $flashError, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?= $content ?>

    <footer class="landing-footer">
        <div class="footer-grid">
            <div>
                <p class="footer-brand"><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></p>
                <p class="footer-copy">Biblioteca digital para leer, escribir y conectar con historias.</p>
            </div>
            <div>
                <p class="footer-title">Legal</p>
                <a href="#">Términos de uso</a>
                <a href="#">Privacidad</a>
                <a href="#">Cookies</a>
            </div>
            <div>
                <p class="footer-title">Comunidad</p>
                <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Crear cuenta</a>
                <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Iniciar sesión</a>
                <a href="#">Ayuda</a>
            </div>
            <div>
                <p class="footer-title">Redes</p>
                <a href="#" rel="noopener">Instagram</a>
                <a href="#" rel="noopener">TikTok</a>
                <a href="#" rel="noopener">X / Twitter</a>
            </div>
        </div>
        <p class="footer-bottom">© <?= date('Y') ?> <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?>. Proyecto académico de Ingeniería de Software.</p>
    </footer>

    <div class="auth-modal" id="auth-modal" hidden>
        <div class="auth-modal-backdrop" data-close-modal></div>
        <div class="auth-modal-card" role="dialog" aria-modal="true" aria-labelledby="auth-modal-title">
            <button type="button" class="auth-modal-close" data-close-modal aria-label="Cerrar">×</button>
            <p class="eyebrow">Únete a Lumen</p>
            <h2 id="auth-modal-title">Esta historia te está esperando</h2>
            <p class="lead" id="auth-modal-text">
                Inicia sesión o crea una cuenta gratis para leer, guardar en tu biblioteca y seguir a tus autores favoritos.
            </p>
            <div class="actions">
                <a class="btn landing-btn" id="auth-modal-register" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Crear cuenta</a>
                <a class="btn btn-ghost landing-btn-ghost" id="auth-modal-login" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Iniciar sesión</a>
            </div>
        </div>
    </div>

    <script src="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/js/theme.js"></script>
    <script src="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/assets/js/landing.js"></script>
</body>
</html>
