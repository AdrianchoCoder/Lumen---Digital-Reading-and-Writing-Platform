<?php
/** @var string $appName */
/** @var string $appUrl */
/** @var string $dbStatus */
/** @var bool $dbOk */
/** @var array|null $authUser */
?>
<section class="hero-check">
    <p class="eyebrow">Módulos 1–3</p>
    <h1><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">
        Núcleo MVC, base de datos y autenticación listos.
        El diseño visual completo llegará en el módulo 9.
    </p>
    <p class="db <?= $dbOk ? 'ok' : 'warn' ?>">
        Base de datos: <?= htmlspecialchars($dbStatus, ENT_QUOTES, 'UTF-8') ?>
    </p>

    <?php if (is_array($authUser)): ?>
        <p class="lead">
            Sesión activa como
            <strong><?= htmlspecialchars($authUser['display_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
            (<?= htmlspecialchars($authUser['role'] ?? '', ENT_QUOTES, 'UTF-8') ?>).
        </p>
    <?php else: ?>
        <p class="actions">
            <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Crear cuenta</a>
            <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Iniciar sesión</a>
        </p>
    <?php endif; ?>
</section>
